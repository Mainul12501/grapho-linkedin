<?php

namespace App\Models\Backend;

use App\Models\Backend\EmployerCompany;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class UserProfileView extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'employee_id',
        'employer_id',
        'viewed_by',
        'employer_company_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'user_profile_views';

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function employerCompany()
    {
        return $this->belongsTo(EmployerCompany::class);
    }
}
