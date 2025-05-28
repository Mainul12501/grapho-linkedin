<?php

namespace App\Models\Backend;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationDegreeName extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['degree_name', 'note', 'status', 'slug'];

    protected $searchableFields = ['*'];

    protected $table = 'education_degree_names';

    public static function createOrUpdateEducationDegreeName($request, $educationDegreeName = null)
    {
        if (!$educationDegreeName) {
            $educationDegreeName = new self();
        }
        $educationDegreeName->degree_name = $request->degree_name;
        $educationDegreeName->note = $request->note;
        $educationDegreeName->status = $request->status == 'on' ? 1 : 0;
        $educationDegreeName->slug = str_replace(' ', '-', $request->degree_name);
        $educationDegreeName->save();
        return $educationDegreeName;
    }

    public function employeeEducations()
    {
        return $this->hasMany(EmployeeEducation::class);
    }
}
