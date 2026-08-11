<?php

namespace App\Models\TwilioVideo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class CallLog extends Model
{
    use HasFactory;

    protected $table = 'call_logs';
    protected $fillable = [
        'room_name',
        'host_id',
        'type',
        'started_at',
        'ended_at',
        'participants',
        'notes',
    ];

    protected $casts = [
        'participants' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function host()
    {
        return $this->belongsTo(\App\Models\User::class, 'host_id');
    }
}
