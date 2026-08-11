<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SendNotification extends Model
{
    protected $fillable = [
        'created_by',
        'send_user_type',
        'msg',
        'method',
        'status',
        'send_count',
    ];
    public static function createOrUpdateSendNotification($request, $sendNotification = null)
    {
        if (!$sendNotification)
        {
            $sendNotification = new SendNotification();
        }
        $sendNotification->created_by = $sendNotification->created_by ?? auth()->id();
        $sendNotification->send_user_type = $request->send_user_type;
        $sendNotification->msg = $request->msg;
        $sendNotification->method = $request->method;
        $sendNotification->status = $request->status == 'on' ? 1 : 0;
        $sendNotification->save();
        return $sendNotification;
    }

    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
