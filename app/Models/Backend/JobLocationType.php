<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobLocationType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'note', 'slug', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'job_location_types';

    public static function createOrUpdateJobLocationType($request, $jobLocationType = null)
    {
        if (!$jobLocationType) {
            $jobLocationType = new self();
        }
        $jobLocationType->name = $request->name;
        $jobLocationType->note = $request->note;
        $jobLocationType->status = $request->status == 'on' ? 1 : 0;
        $jobLocationType->slug = str_replace(' ', '-', $request->name);
        $jobLocationType->save();
        return $jobLocationType;
    }

    public function jobs()
    {
        return $this->hasMany(JobTask::class, 'job_location_type_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
