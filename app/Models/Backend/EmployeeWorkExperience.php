<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeWorkExperience extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'title',
        'company_name',
        'company_logo',
        'position',
        'job_responsibilities',
        'start_date',
        'end_date',
        'office_address',
        'duration',
        'is_working_currently',
        'job_type',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'employee_work_experiences';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
