<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Events\CallAccepted;
use App\Events\CallEnded;
use App\Events\CallInitiated;
use App\Events\CallRejected;
use App\Http\Controllers\Controller;
use App\Models\Backend\Call;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ZegoCloudMobileController extends Controller
{
    protected $pushNotificationService;

    public function __construct(PushNotificationService $pushNotificationService)
    {
        $this->pushNotificationService = $pushNotificationService;
    }

    /**
     * Register or update device token for push notifications
     */
    public function registerDevice(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
            'device_platform' => 'required|in:ios,android',
        ]);

        $user = Auth::user();

        $user->update([
            'device_token' => $request->device_token,
            'device_platform' => $request->device_platform,
            'is_online' => true,
            'last_seen' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'device_platform' => $user->device_platform,
                'is_online' => $user->is_online,
            ]
        ]);
    }

    /**
     * Update user online status
     */
    public function updateOnlineStatus(Request $request)
    {
        $request->validate([
            'is_online' => 'required|boolean',
        ]);

        $user = Auth::user();
        $user->update([
            'is_online' => $request->is_online,
            'last_seen' => now(),
        ]);

        return response()->json([
            'success' => true,
            'is_online' => $user->is_online,
            'last_seen' => $user->last_seen,
        ]);
    }

    /**
     * Initiate a call (can be called from mobile or web)
     */
    public function initiateCall(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'call_type' => 'required|in:audio,video',
        ]);

        $caller = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        if ($caller->id === $receiver->id) {
            return response()->json(['error' => 'You cannot call yourself'], 400);
        }

        $roomId = 'room_' . Str::random(20) . '_' . time();

        $call = Call::create([
            'caller_id' => $caller->id,
            'receiver_id' => $receiver->id,
            'room_id' => $roomId,
            'call_type' => $request->call_type,
            'status' => 'initiated',
        ]);

        // Broadcast the call event
        broadcast(new CallInitiated($call))->toOthers();

        // Send push notification to receiver if they have a device token
        if ($receiver->device_token) {
            $this->pushNotificationService->sendCallNotification(
                $receiver,
                $caller,
                $call,
                'incoming'
            );
        }

        return response()->json([
            'success' => true,
            'call' => $call->load('caller', 'receiver'),
            'room_id' => $roomId,
            'zegocloud_config' => [
                'app_id' => config('services.zegocloud.app_id'),
                'room_id' => $roomId,
                'user_id' => (string)$caller->id,
                'user_name' => $caller->name,
            ]
        ]);
    }

    /**
     * Accept a call from mobile
     */
    public function acceptCall(Request $request, $callId)
    {
        $call = Call::findOrFail($callId);
        $user = Auth::user();

        if ($call->receiver_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($call->status !== 'initiated') {
            return response()->json(['error' => 'Call is not available'], 400);
        }

        $call->update([
            'status' => 'accepted',
            'started_at' => now(),
        ]);

        // Broadcast the call accepted event
        broadcast(new CallAccepted($call))->toOthers();

        return response()->json([
            'success' => true,
            'call' => $call->load('caller', 'receiver'),
            'zegocloud_config' => [
                'app_id' => config('services.zegocloud.app_id'),
                'room_id' => $call->room_id,
                'user_id' => (string)$user->id,
                'user_name' => $user->name,
            ]
        ]);
    }

    /**
     * Reject a call from mobile
     */
    public function rejectCall(Request $request, $callId)
    {
        $call = Call::findOrFail($callId);
        $user = Auth::user();

        if ($call->receiver_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!in_array($call->status, ['initiated', 'ringing'])) {
            return response()->json(['error' => 'Call cannot be rejected'], 400);
        }

        $call->update([
            'status' => 'rejected',
            'ended_at' => now(),
        ]);

        // Broadcast the call rejected event
        broadcast(new CallRejected($call))->toOthers();

        // Notify caller that call was rejected
        $caller = $call->caller;
        if ($caller->device_token) {
            $this->pushNotificationService->sendCallNotification(
                $caller,
                $user,
                $call,
                'rejected'
            );
        }

        return response()->json(['success' => true, 'message' => 'Call rejected']);
    }

    /**
     * End an active call
     */
    public function endCall(Request $request, $callId)
    {
        $call = Call::findOrFail($callId);
        $user = Auth::user();

        if (!in_array($user->id, [$call->caller_id, $call->receiver_id])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($call->status === 'ended') {
            return response()->json(['success' => true, 'message' => 'Call already ended']);
        }

        $duration = null;
        if ($call->started_at) {
            $duration = now()->diffInSeconds($call->started_at);
        }

        $call->update([
            'status' => 'ended',
            'ended_at' => now(),
            'duration' => $duration,
        ]);

        $targetUserId = $user->id === $call->caller_id ? $call->receiver_id : $call->caller_id;

        // Broadcast the call ended event
        broadcast(new CallEnded($call, $targetUserId))->toOthers();

        // Notify the other party
        $targetUser = User::find($targetUserId);
        if ($targetUser && $targetUser->device_token) {
            $this->pushNotificationService->sendCallNotification(
                $targetUser,
                $user,
                $call,
                'ended'
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Call ended',
            'duration' => $duration
        ]);
    }

    /**
     * Get active calls for the authenticated user
     */
    public function getActiveCalls()
    {
        $user = Auth::user();

        $activeCalls = Call::where(function ($query) use ($user) {
            $query->where('caller_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->whereIn('status', ['initiated', 'ringing', 'accepted'])
        ->with(['caller', 'receiver'])
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'active_calls' => $activeCalls
        ]);
    }

    /**
     * Get call history
     */
    public function getCallHistory(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 20);

        $callHistory = Call::where(function ($query) use ($user) {
            $query->where('caller_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })
        ->with(['caller', 'receiver'])
        ->latest()
        ->paginate($perPage);

        return response()->json([
            'success' => true,
            'call_history' => $callHistory
        ]);
    }

    /**
     * Get call details
     */
    public function getCallDetails($callId)
    {
        $call = Call::with(['caller', 'receiver'])->findOrFail($callId);
        $user = Auth::user();

        if (!in_array($user->id, [$call->caller_id, $call->receiver_id])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'call' => $call
        ]);
    }

    /**
     * Check if user is available for calls
     */
    public function checkUserAvailability($userId)
    {
        $targetUser = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Check if user has active calls
        $hasActiveCall = Call::where(function ($query) use ($targetUser) {
            $query->where('caller_id', $targetUser->id)
                  ->orWhere('receiver_id', $targetUser->id);
        })
        ->whereIn('status', ['initiated', 'ringing', 'accepted'])
        ->exists();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $targetUser->id,
                'name' => $targetUser->name,
                'is_online' => $targetUser->is_online,
                'last_seen' => $targetUser->last_seen,
            ],
            'is_available' => !$hasActiveCall && $targetUser->is_online,
            'has_active_call' => $hasActiveCall,
        ]);
    }

    /**
     * Generate ZegoCloud token for mobile
     */
    public function generateToken(Request $request)
    {
        $request->validate([
            'room_id' => 'required|string',
        ]);

        $user = Auth::user();

        return response()->json([
            'success' => true,
            'zegocloud_config' => [
                'app_id' => config('services.zegocloud.app_id'),
                'server_secret' => config('services.zegocloud.server_secret'),
                'user_id' => (string)$user->id,
                'user_name' => $user->name,
                'room_id' => $request->room_id,
            ]
        ]);
    }
}
