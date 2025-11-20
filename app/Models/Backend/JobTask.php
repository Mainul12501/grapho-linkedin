<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobTask extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'job_title',
        'job_type_id',
        'job_location_type_id',
        'user_id',
        'industry_id',
        'employer_company_id',
        'required_experience',
        'job_pref_salary_payment_type',
        'salary_amount',
        'salary_range_start',
        'salary_range_end',
        'description',
        'deadline',
        'require_sector_looking_for',
        'slug',
        'status',
        'banner_image',
        'cgpa',
        'university_preference',
        'field_of_study_preference',
        'is_custom_exp',
        'gender',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'job_tasks';

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function jobLocationType()
    {
        return $this->belongsTo(JobLocationType::class);
    }

    public function Employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employerCompany()
    {
        return $this->belongsTo(EmployerCompany::class);
    }
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function employeeAppliedJobs()
    {
        return $this->hasMany(EmployeeAppliedJob::class);
    }

    // Add this relationship
    public function employeeSavedJobs()
    {
        return $this->belongsToMany(User::class, 'job_task_user', 'job_task_id', 'user_id');
        // Adjust table name based on your pivot table name
        // Common names: employee_job_task, job_task_user, employee_saved_jobs
    }

    public function employerPrefferableUniversityNames()
    {
        return $this->belongsToMany(UniversityName::class);
    }

    public function employerPrefferableFieldOfStudyNames()
    {
        return $this->belongsToMany(FieldOfStudy::class);
    }

    public function jobRequiredskills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function appliedEmployees()
    {
        return $this->hasManyThrough(
            User::class,
            EmployeeAppliedJob::class,
            'job_id'
        );
    }
}
