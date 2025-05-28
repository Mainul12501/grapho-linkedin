<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'note', 'slug', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'job_types';

    public static function createOrUpdateJobType($request, $jobType = null)
    {
        if (!$jobType) {
            $jobType = new self();
        }
        $jobType->name = $request->name;
        $jobType->note = $request->note;
        $jobType->status = $request->status == 'on' ? 1 : 0;
        $jobType->slug = str_replace(' ', '-', $request->name);
        $jobType->save();
        return $jobType;
    }

    public function jobs()
    {
        return $this->hasMany(JobTask::class, 'job_type_id');
    }
}
