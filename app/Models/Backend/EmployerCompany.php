<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployerCompany extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'industry_id',
        'employer_company_category_id',
        'name',
        'email',
        'phone',
        'address',
        'website',
        'company_overview',
        'founded_on',
        'total_employees',
        'status',
        'slug',
        'logo',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'employer_companies';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function ownerUserInfo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function jobs()
    {
        return $this->hasMany(JobTask::class, 'employer_company_id');
    }

    public function employerCompanyCategory()
    {
        return $this->belongsTo(EmployerCompanyCategory::class);
    }

    public function userProfileViews()
    {
        return $this->hasMany(UserProfileView::class);
    }
}
