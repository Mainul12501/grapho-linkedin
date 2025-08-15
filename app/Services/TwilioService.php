<?php

namespace App\Services;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

class TwilioService
{
    /**
     * Create a new class instance.
     */
    protected $client;
    protected $sid;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid') ?: env('TWILIO_ACCOUNT_SID');
        $this->apiKey = config('services.twilio.key') ?: env('TWILIO_API_KEY');
        $this->apiSecret = config('services.twilio.secret') ?: env('TWILIO_API_SECRET');

        $this->client = new Client($this->apiKey, $this->apiSecret, $this->sid);
    }

    /**
     * Generate Access Token JWT for Twilio Video
     *
     * @param string $identity
     * @param string $room
     * @param int $ttlSeconds
     * @return string
     */
    public function createVideoToken(string $identity, string $room, int $ttlSeconds = 3600): string
    {
        $token = new AccessToken($this->sid, $this->apiKey, $this->apiSecret, $ttlSeconds, $identity);
        $grant = new VideoGrant();
        $grant->setRoom($room);
        $token->addGrant($grant);
        return $token->toJWT();
    }

    /**
     * Kick / disconnect a participant from a room using Twilio REST API
     * @param string $roomName
     * @param string $participantIdentityOrSid
     */
    public function disconnectParticipant(string $roomName, string $participantIdentityOrSid)
    {
        // Participant resource: update status to 'disconnected'
        // Twilio PHP helper expects the Participant SID or Identity endpoint needs participant SID retrieval.
        $participants = $this->client->video->rooms($roomName)->participants->read();
        foreach ($participants as $p) {
            if ($p->sid === $participantIdentityOrSid || $p->identity === $participantIdentityOrSid) {
                return $this->client->video->rooms($roomName)
                    ->participants($p->sid)
                    ->update(['status' => 'disconnected']);
            }
        }
        throw new \Exception("Participant not found in room");
    }

    /**
     * End a room (complete it)
     */
    public function completeRoom(string $roomName)
    {
        return $this->client->video->rooms($roomName)->update(['status' => 'completed']);
    }
}
