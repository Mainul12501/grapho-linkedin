<?php

namespace App\Events;

use App\Models\Backend\GroupCall;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupCallEnded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $groupCall;

    public function __construct(GroupCall $groupCall)
    {
        $this->groupCall = $groupCall;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('group-call.' . $this->groupCall->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'call.ended';
    }

    public function broadcastWith(): array
    {
        return [
            'group_call_id' => $this->groupCall->id,
            'duration' => $this->groupCall->duration,
        ];
    }
}
