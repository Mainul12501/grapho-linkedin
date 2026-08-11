<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationSubjectName extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'field_of_study_id',
        'subject_name',
        'note',
        'status',
        'slug',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'education_subject_names';

    public static function createOrUpdateEducationalSubjectName($request, $educationalSubjectName = null)
    {
        if (!$educationalSubjectName) {
            $educationalSubjectName = new self();
        }
        $educationalSubjectName->subject_name = $request->subject_name;
        $educationalSubjectName->field_of_study_id = $request->field_of_study_id;
        $educationalSubjectName->note = $request->note;
//        $fieldOfStudy->is_approved = $request->is_approved == 'on' ? 1 : 0;
        $educationalSubjectName->status = $request->status == 'on' ? 1 : 0;
        $educationalSubjectName->slug = str_replace(' ', '-', $request->subject_name);
        $educationalSubjectName->save();
        return $educationalSubjectName;
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function employeeEducations()
    {
        return $this->hasMany(EmployeeEducation::class, 'main_subject_id');
    }
}
