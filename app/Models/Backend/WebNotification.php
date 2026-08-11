<?php

namespace App\Models\Backend;

use App\Models\Backend\RoleManagement\Role;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebNotification extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'role_id',
        'msg',
        'is_seen',
        'status',
        'job_task_id',
        'notification_type',
        'viewer_id',
        'viewed_user_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'web_notifications';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userRole()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function jobTask()
    {
        return $this->belongsTo(JobTask::class);
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_id');
    }

    public function viewerUser()
    {
        return $this->belongsTo(User::class, 'viewed_user_id');
    }
}
