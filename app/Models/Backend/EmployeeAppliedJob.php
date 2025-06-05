<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAppliedJob extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'status', 'job_task_id'];

    protected $searchableFields = ['*'];

    protected $table = 'employee_applied_jobs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobTask()
    {
        return $this->belongsTo(JobTask::class);
    }
}
