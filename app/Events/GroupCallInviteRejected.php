<?php

namespace App\Events;

use App\Models\Backend\GroupCall;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupCallInviteRejected implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $groupCall;
    public $user;

    public function __construct(GroupCall $groupCall, User $user)
    {
        $this->groupCall = $groupCall;
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('group-call.' . $this->groupCall->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'invite.rejected';
    }

    public function broadcastWith(): array
    {
        return [
            'group_call_id' => $this->groupCall->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
}
