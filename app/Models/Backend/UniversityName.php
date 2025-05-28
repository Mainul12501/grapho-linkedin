<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniversityName extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'address', 'is_approved', 'status', 'slug'];

    protected $searchableFields = ['*'];

    protected $table = 'university_names';

    public static function createOrUpdateUniversityNames($request, $fieldOfStudy = null)
    {
        if (!$fieldOfStudy) {
            $fieldOfStudy = new self();
        }
        $fieldOfStudy->name = $request->name;
        $fieldOfStudy->address = $request->address;
//        $fieldOfStudy->is_approved = $request->is_approved == 'on' ? 1 : 0;
        $fieldOfStudy->status = $request->status == 'on' ? 1 : 0;
        $fieldOfStudy->slug = str_replace(' ', '-', $request->name);
        $fieldOfStudy->save();
        return $fieldOfStudy;
    }

    public function employeeEducations()
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function jobTasks()
    {
        return $this->belongsToMany(JobTask::class);
    }
}
