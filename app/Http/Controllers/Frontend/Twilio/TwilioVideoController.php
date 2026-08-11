<?php

namespace App\Http\Controllers\Frontend\Twilio;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\TwilioVideo\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Auth;

class TwilioVideoController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
//        $this->middleware('auth:sanctum')->only(['inviteCreate','kickParticipant','logs','completeRoom']);
    }

    // Returns blade view
    public function viewPage(Request $request, $type = 'video')
    {
        if (isset($request->room))
        {
            $existRoom = CallLog::where(['host_id' => ViewHelper::loggedUser()->id, 'room_name' => $request->room])->first();
        }
        if (isset($existRoom))
        {
            $room = $existRoom->room_name;
        } else {
            $room = 'room_' . Str::random(10);
            $call = CallLog::create([
                'room_name' => $room,
                'host_id' => auth()->id(),
                'type' => $request->get('type', 'both'),
                'started_at' => null,
                'participants' => null,
            ]);
        }

        $data = [
            'previousUrl'   => url()->previous() ?? url('/'),
            'type'  => $type,
            'roomName'  => $room,
            'invite_url' => route('twilio.view') . '?room=' . $room,
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.twilio.index');
        return view('frontend.twilio.index');
    }

    // Generate token
    public function token(Request $request)
    {
        $data = $request->validate([
            'room' => ['required','string','max:100'],
            'name' => ['nullable','string','max:60'],
        ]);

        $identity = $data['name'] ?? ('Guest_' . Str::random(6));

        // Check if this room has a CallLog with a host, and if current user is host
        $call = CallLog::where('room_name', $data['room'])->first();
        $is_host = false;
        if ($call && auth()->check() && auth()->id() === $call->host_id) {
            $is_host = true;
        }

        $jwt = $this->twilio->createVideoToken($identity, $data['room'], 3600);

        return response()->json([
            'token' => $jwt,
            'room' => $data['room'],
            'user' => $identity,
            'expires_in' => 3600,
            'is_host' => $is_host,
        ]);
    }

    public function audioToken(Request $request)
    {
        $data = $request->validate([
            'room' => 'required|string|max:100',
            'name' => 'nullable|string|max:60',
        ]);

        $sid    = env('TWILIO_ACCOUNT_SID');
        $key    = env('TWILIO_API_KEY');
        $secret = env('TWILIO_API_SECRET');

        $identity = $data['name'] ?? 'Guest_' . rand(1000, 9999);

        $token = new AccessToken($sid, $key, $secret, 3600, $identity);
        $grant = new VideoGrant();
        $grant->setRoom($data['room']);
        $token->addGrant($grant);

        return response()->json([
            'token' => $token->toJWT(),
            'identity' => $identity
        ]);
    }

    // Invite generator: creates a unique room name and CallLog with host
    public function inviteCreate(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:audio,video,both',
            'label' => 'nullable|string|max:100',
        ]);

        $room = 'room_' . Str::random(10);
        $call = CallLog::create([
            'room_name' => $room,
            'host_id' => auth()->id(),
            'type' => $request->get('type', 'both'),
            'started_at' => null,
            'participants' => null,
        ]);

        return response()->json([
            'room' => $room,
            'invite_url' => route('twilio.view') . '?room=' . $room
        ], 201);
    }

    // Kick participant (authenticated host only)
    public function kickParticipant(Request $request)
    {
        $request->validate([
            'room' => 'required|string',
            'participant' => 'required|string',
        ]);

        $room = $request->get('room');
        $participant = $request->get('participant');

        // verify host
        $call = CallLog::where('room_name', $room)->first();
        if (! $call || auth()->id() !== $call->host_id) {
            return response()->json(['ok' => false, 'message' => 'Forbidden'], 403);
        }

        try {
            $res = $this->twilio->disconnectParticipant($room, $participant);
            return response()->json(['ok' => true, 'message' => 'Participant disconnected']);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => $e->getMessage()], 400);
        }
    }

    // Optional endpoints for call logs listing (protected)
    public function logs()
    {
        return CallLog::with('host')->latest()->paginate(25);
    }

    // Optional: mark call started/ended
    public function markStarted(Request $request)
    {
        $request->validate(['room' => 'required|string']);
        $call = CallLog::where('room_name', $request->room)->first();
        if ($call && auth()->id() === $call->host_id) {
            $call->update(['started_at' => now()]);
            return response()->json(['ok'=>true]);
        }
        return response()->json(['ok'=>false],403);
    }

    public function completeRoom(Request $request)
    {
        $request->validate(['room' => 'required|string']);
        $call = CallLog::where('room_name', $request->room)->first();
        if ($call && auth()->id() === $call->host_id) {
            $this->twilio->completeRoom($request->room);
            $call->update(['ended_at' => now()]);
            return response()->json(['ok'=>true]);
        }
        return response()->json(['ok'=>false],403);
    }
}
