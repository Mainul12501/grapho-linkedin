<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeEducation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'education_degree_name_id',
        'university_name_id',
        'field_of_study_id',
        'main_subject_id',
        'starting_date',
        'ending_date',
        'passing_year',
        'cgpa',
        'address',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'employee_educations';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educationDegreeName()
    {
        return $this->belongsTo(EducationDegreeName::class);
    }

    public function universityName()
    {
        return $this->belongsTo(UniversityName::class);
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function mainSubject()
    {
        return $this->belongsTo(EducationSubjectName::class, 'main_subject_id');
    }
}
