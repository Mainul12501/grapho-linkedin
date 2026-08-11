<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatifyDeletedConversation extends Model
{
    protected $table = 'chatify_deleted_conversations';

    protected $fillable = [
        'user_id',
        'contact_id',
        'deleted_at',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
