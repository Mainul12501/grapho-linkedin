<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupCallParticipant extends Model
{
    protected $fillable = [
        'group_call_id',
        'user_id',
        'status',
        'invited_at',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    public function groupCall(): BelongsTo
    {
        return $this->belongsTo(GroupCall::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeJoined($query)
    {
        return $query->where('status', 'joined');
    }

    public function scopeInvited($query)
    {
        return $query->where('status', 'invited');
    }
}
