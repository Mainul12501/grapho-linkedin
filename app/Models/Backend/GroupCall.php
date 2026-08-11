<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GroupCall extends Model
{
    protected $fillable = [
        'host_id',
        'room_id',
        'name',
        'call_type',
        'status',
        'max_participants',
        'started_at',
        'ended_at',
        'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(GroupCallParticipant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_call_participants')
            ->withPivot(['status', 'invited_at', 'joined_at', 'left_at'])
            ->withTimestamps();
    }

    public function activeParticipants(): HasMany
    {
        return $this->hasMany(GroupCallParticipant::class)->where('status', 'joined');
    }

    public function invitedParticipants(): HasMany
    {
        return $this->hasMany(GroupCallParticipant::class)->where('status', 'invited');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['initiated', 'active']);
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function isHost(User $user): bool
    {
        return $this->host_id === $user->id;
    }

    public function isParticipant(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    public function canJoin(): bool
    {
        return $this->status !== 'ended' &&
               $this->activeParticipants()->count() < $this->max_participants;
    }
}
