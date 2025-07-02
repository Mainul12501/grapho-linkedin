<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Backend\EmployeeAppliedJob;
use App\Models\Backend\EmployerCompany;
use App\Models\Backend\JobTask;
use App\Models\Backend\RoleManagement\Role;
use App\Models\Backend\UserProfileView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'employer_company_id',
        'name',
        'email',
        'password',
        'mobile',
        'user_type',
        'provider',
        'provider_id',
        'google_id',
        'organization_name',
        'subscription_started_from',
        'profile_image',
        'profile_title',
        'address',
        'website',
        'fb_link',
        'linkedin_link',
        'x_link',
        'gender',
        'user_slug',
        'dob',
        'language',
        'is_open_for_hire',
        'employer_agent_active_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

//    public function setProviderTokenAttribute($value){
//        return $this->attributes['provider_token'] = Crypt::crypt($value);
//    }
//
//    public function getProviderTokenAttribute($value)
//    {
//        return Crypt::decrypt($value);
//    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function employeeWorkExperiences()
    {
        return $this->hasMany(EmployeeWorkExperience::class);
    }

    public function employeeEducations()
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function employeeDocuments()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function webNotifications()
    {
        return $this->hasMany(WebNotification::class);
    }

    public function employerCompany()
    {
        return $this->belongsTo(EmployerCompany::class);
    }

    public function employerCompanies()
    {
        return $this->hasMany(EmployerCompany::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobTask::class, 'user_id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(EmployeeAppliedJob::class, 'user_id');
    }
    public function appliedJobsWithJobDetails()
    {
        return $this->hasMany(EmployeeAppliedJob::class, 'user_id')->with('jobTask');
    }

    public function viewEmployerIds()
    {
        return $this->hasMany(UserProfileView::class, 'employer_id');
    }

    public function viewEmployeeIds()
    {
        return $this->hasMany(UserProfileView::class, 'employee_id');
    }

    public function employeeSavedJobs()
    {
        return $this->belongsToMany(JobTask::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function employeeAppliedJobs()
    {
        return $this->hasManyThrough(JobTask::class, EmployeeAppliedJob::class, 'user_id', 'id', 'id', 'job_task_id');
    }

    public function viewedEmployees()
    {
        return $this->hasManyThrough(
            User::class,
            UserProfileView::class,
            'id',
            'employee_id'
        );
    }

    public function viewedEmployers()
    {
        return $this->hasManyThrough(
            User::class,
            UserProfileView::class,
            'employee_id',
            'id',
            'id',
            'employer_id'
        );
    }

    public function viewedEmployerCompanies()
    {
        return $this->hasManyThrough(
            EmployerCompany::class,
            UserProfileView::class,
            'id',
            'employer_company_id'
        );
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->email, config('auth.super_admins'));
    }

}
