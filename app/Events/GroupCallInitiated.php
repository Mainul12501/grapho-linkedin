<?php

namespace App\Events;

use App\Models\Backend\GroupCall;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupCallInitiated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $groupCall;
    public $invitedUserId;

    public function __construct(GroupCall $groupCall, int $invitedUserId)
    {
        $this->groupCall = $groupCall->load('host.employerCompany');
        $this->invitedUserId = $invitedUserId;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->invitedUserId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'group.call.initiated';
    }

    public function broadcastWith(): array
    {
        return [
            'group_call_id' => $this->groupCall->id,
            'room_id' => $this->groupCall->room_id,
            'call_type' => $this->groupCall->call_type,
            'name' => $this->groupCall->name,
            'host' => [
                'id' => $this->groupCall->host->id,
                'name' => $this->groupCall->host->employerCompany->name ?? $this->groupCall->host->name,
                'profile_photo_url' => $this->groupCall->host->profile_photo_url,
            ],
        ];
    }
}
