<?php

namespace App\Http\Controllers\Frontend\ZegoCloud;

use App\Events\GroupCallEnded;
use App\Events\GroupCallInitiated;
use App\Events\GroupCallInviteRejected;
use App\Events\GroupCallParticipantJoined;
use App\Events\GroupCallParticipantLeft;
use App\Helpers\CustomHelper;
use App\Helpers\FirebaseHelper;
use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\GroupCall;
use App\Models\Backend\GroupCallParticipant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ZegoGroupCallController extends Controller
{
    /**
     * View group call page
     */
    public function viewCallPage(Request $request)
    {
        $user = CustomHelper::loggedUser();
        $roomId = $request->query('roomID');
        $callType = $request->query('type', 'video');
        $groupCallId = $request->query('groupCallId');

        if (!$user) {
            return redirect()->route('auth.user-login-page');
        }

        $groupCall = null;
        if ($groupCallId) {
            $groupCall = GroupCall::with(['host', 'activeParticipants.user'])->find($groupCallId);
        }

        return ViewHelper::checkViewForApi([
            'user' => $user,
            'roomID' => $roomId,
            'callType' => $callType,
            'groupCall' => $groupCall,
        ], 'frontend.zegocloud.group-call');

        return view('frontend.zegocloud.group-call', [
            'user' => $user,
            'roomID' => $roomId,
            'callType' => $callType,
            'groupCall' => $groupCall,
        ]);
    }

    /**
     * Initiate a group call
     */
    public function initiateCall(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'call_type' => 'required|in:audio,video',
        ]);

        $host = ViewHelper::loggedUser();

        if (!in_array($host->user_type, ['employer', 'sub_employer'])) {
            return response()->json(['error' => 'Only employers can initiate group calls'], 403);
        }

        if ($host->id == $request->receiver_id) {
            return response()->json(['error' => 'You cannot call yourself'], 400);
        }

        $receiver = User::findOrFail($request->receiver_id);
        $roomId = 'group_room_' . Str::random(20) . '_' . time();

        $groupCall = GroupCall::create([
            'host_id' => $host->id,
            'room_id' => $roomId,
            'name' => $host->name . "'s Group Call",
            'call_type' => $request->call_type,
            'status' => 'initiated',
            'max_participants' => 10,
        ]);

        // Add host as a participant
        GroupCallParticipant::create([
            'group_call_id' => $groupCall->id,
            'user_id' => $host->id,
            'status' => 'joined',
            'invited_at' => now(),
            'joined_at' => now(),
        ]);

        // Invite the receiver
        GroupCallParticipant::create([
            'group_call_id' => $groupCall->id,
            'user_id' => $receiver->id,
            'status' => 'invited',
            'invited_at' => now(),
        ]);

        broadcast(new GroupCallInitiated($groupCall, $receiver->id))->toOthers();

        if ($receiver->fcm_token) {
            FirebaseHelper::sendGroupCallInviteNotification(
                receiverId: $receiver->id,
                hostName: $host->name,
                hostId: $host->id,
                groupCallId: $groupCall->id,
                roomId: $roomId,
                callType: $request->call_type,
                hostPhoto: $host->profile_photo_url,
                callName: $groupCall->name
            );
        }

        return response()->json([
            'success' => true,
            'group_call' => $groupCall->load('participants.user'),
            'room_url' => route('zego.group.call-page', [
                'roomID' => $roomId,
                'type' => $request->call_type,
                'groupCallId' => $groupCall->id
            ])
        ]);
    }

    /**
     * Add more participants to an ongoing group call
     */
    public function addParticipants(Request $request, GroupCall $groupCall)
    {
        $request->validate([
            'participant_ids' => 'required|array|min:1',
            'participant_ids.*' => 'exists:users,id',
        ]);

        $user = CustomHelper::loggedUser();

        if (!$groupCall->isHost($user) && !$groupCall->isParticipant($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($groupCall->status === 'ended') {
            return response()->json(['error' => 'Call has ended'], 400);
        }

        // Validate that added users are within the caller's team
        $allowedIds = $this->getCallableUserIds($user);

        $host = $groupCall->host;
        $addedParticipants = [];

        foreach ($request->participant_ids as $participantId) {
            if (!in_array($participantId, $allowedIds)) {
                continue;
            }

            if ($groupCall->participants()->where('user_id', $participantId)->exists()) {
                continue;
            }

            $participant = User::find($participantId);
            if (!$participant) continue;

            GroupCallParticipant::create([
                'group_call_id' => $groupCall->id,
                'user_id' => $participantId,
                'status' => 'invited',
                'invited_at' => now(),
            ]);

            $addedParticipants[] = $participant;

            broadcast(new GroupCallInitiated($groupCall, $participantId))->toOthers();

            if ($participant->fcm_token) {
                FirebaseHelper::sendGroupCallInviteNotification(
                    receiverId: $participant->id,
                    hostName: $host->name,
                    hostId: $host->id,
                    groupCallId: $groupCall->id,
                    roomId: $groupCall->room_id,
                    callType: $groupCall->call_type,
                    hostPhoto: $host->profile_photo_url,
                    callName: $groupCall->name
                );
            }
        }

        return response()->json([
            'success' => true,
            'added_count' => count($addedParticipants),
            'group_call' => $groupCall->load('participants.user'),
        ]);
    }

    /**
     * Join a group call
     */
    public function joinCall(Request $request, GroupCall $groupCall)
    {
//        $user = Auth::user();
        $user = CustomHelper::loggedUser();

        $participant = $groupCall->participants()->where('user_id', $user->id)->first();

        if (!$participant) {
            return response()->json(['error' => 'You are not invited to this call'], 403);
        }

        if (!$groupCall->canJoin()) {
            return response()->json(['error' => 'Call is full or has ended'], 400);
        }

        $participant->update([
            'status' => 'joined',
            'joined_at' => now(),
        ]);

        // Update call status to active if this is the first join after initiation
        if ($groupCall->status === 'initiated') {
            $groupCall->update([
                'status' => 'active',
                'started_at' => now(),
            ]);
        }

        broadcast(new GroupCallParticipantJoined($groupCall, $user))->toOthers();

        return response()->json([
            'success' => true,
            'group_call' => $groupCall->load('participants.user'),
            'room_url' => route('zego.group.call-page', [
                'roomID' => $groupCall->room_id,
                'type' => $groupCall->call_type,
                'groupCallId' => $groupCall->id
            ])
        ]);
    }

    /**
     * Reject a group call invitation
     */
    public function rejectCall(Request $request, GroupCall $groupCall)
    {
        $user = CustomHelper::loggedUser();
//        $user = Auth::user();

        $participant = $groupCall->participants()->where('user_id', $user->id)->first();

        if (!$participant || $participant->status !== 'invited') {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $participant->update([
            'status' => 'rejected',
        ]);

        broadcast(new GroupCallInviteRejected($groupCall, $user))->toOthers();

        return response()->json(['success' => true]);
    }

    /**
     * Leave a group call
     */
    public function leaveCall(Request $request, GroupCall $groupCall)
    {
        $user = CustomHelper::loggedUser();
//        $user = Auth::user();

        $participant = $groupCall->participants()->where('user_id', $user->id)->first();

        if (!$participant) {
            return response()->json(['error' => 'You are not in this call'], 400);
        }

        $participant->update([
            'status' => 'left',
            'left_at' => now(),
        ]);

        broadcast(new GroupCallParticipantLeft($groupCall, $user))->toOthers();

        // If host leaves, end the call for everyone
        if ($groupCall->isHost($user)) {
            $this->endCallInternal($groupCall);
        }
        // If no active participants left, end the call
        elseif ($groupCall->activeParticipants()->count() === 0) {
            $this->endCallInternal($groupCall);
        }

        return response()->json(['success' => true]);
    }

    /**
     * End a group call (host only)
     */
    public function endCall(Request $request, GroupCall $groupCall)
    {
        $user = CustomHelper::loggedUser();
//        $user = Auth::user();

        if (!$groupCall->isHost($user)) {
            return response()->json(['error' => 'Only the host can end the call'], 403);
        }

        $this->endCallInternal($groupCall);

        return response()->json(['success' => true]);
    }

    /**
     * Internal method to end a group call
     */
    private function endCallInternal(GroupCall $groupCall)
    {
        if ($groupCall->status === 'ended') {
            return;
        }

        $duration = null;
        if ($groupCall->started_at) {
            $duration = now()->diffInSeconds($groupCall->started_at);
        }

        $groupCall->update([
            'status' => 'ended',
            'ended_at' => now(),
            'duration' => $duration,
        ]);

        // Mark all active participants as left
        $groupCall->participants()->where('status', 'joined')->update([
            'status' => 'left',
            'left_at' => now(),
        ]);

        broadcast(new GroupCallEnded($groupCall));
    }

    /**
     * Get group call details
     */
    public function getCallDetails(GroupCall $groupCall)
    {
        $user = CustomHelper::loggedUser();
//        $user = Auth::user();

        if (!$groupCall->isHost($user) && !$groupCall->isParticipant($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'group_call' => $groupCall->load(['host', 'participants.user'])
        ]);
    }

    /**
     * Get active participants in the call
     */
    public function getParticipants(GroupCall $groupCall)
    {
        $user = CustomHelper::loggedUser();
//        $user = Auth::user();

        if (!$groupCall->isHost($user) && !$groupCall->isParticipant($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'participants' => $groupCall->activeParticipants()->with('user')->get(),
            'invited' => $groupCall->invitedParticipants()->with('user')->get(),
        ]);
    }

    /**
     * Get users that the caller can add to the group call (sub_employers + parent employer + parent's sub_employers)
     */
    public function getCallableUsers(Request $request)
    {
        $user = CustomHelper::loggedUser();
        $groupCallId = $request->query('group_call_id');

        $allowedIds = $this->getCallableUserIds($user);

        // Exclude users already in the call
        $excludeIds = [];
        if ($groupCallId) {
            $groupCall = GroupCall::find($groupCallId);
            if ($groupCall) {
                $excludeIds = $groupCall->participants()->pluck('user_id')->toArray();
            }
        }

        $availableIds = array_diff($allowedIds, $excludeIds);

        $users = User::whereIn('id', $availableIds)
            ->get(['id', 'name', 'email', 'profile_image', 'user_type']);

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Get IDs of users the given user is allowed to call
     */
    private function getCallableUserIds(User $user): array
    {
        $ids = [];

        if ($user->user_type === 'employer') {
            // Employer can add their sub_employers
            $ids = $user->subEmployers()->pluck('id')->toArray();
        } elseif ($user->user_type === 'sub_employer') {
            // Sub_employer can add parent employer + parent's other sub_employers
            if ($user->parentEmployer) {
                $ids[] = $user->parentEmployer->id;
                $siblingIds = $user->parentEmployer->subEmployers()
                    ->where('id', '!=', $user->id)
                    ->pluck('id')
                    ->toArray();
                $ids = array_merge($ids, $siblingIds);
            }
        }

        return $ids;
    }
}
