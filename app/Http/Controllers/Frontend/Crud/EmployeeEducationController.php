<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EducationDegreeName;
use App\Models\Backend\EmployeeEducation;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\UniversityName;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request->all();
//        $request->validate([
//            'passing_year'  => 'required',
//            'university_name_id'  => 'required',
//        ]);
        $validator = Validator::make($request->all(), [
            'passing_year'  => 'required',
            'university_name_id'  => 'required',
        ]);

        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        try {
            $employeeEducation = new EmployeeEducation();
            $employeeEducation->user_id = ViewHelper::loggedUser()->id;
            $employeeEducation->education_degree_name_id    = $request->education_degree_name_id;
            $employeeEducation->university_name_id  = $request->university_name_id;
            $employeeEducation->field_of_study_id   = $request->field_of_study_id;
            $employeeEducation->main_subject_id = $request->main_subject_id;
            $employeeEducation->starting_date   = $request->starting_date;
            $employeeEducation->ending_date = $request->ending_date;
            $employeeEducation->passing_year    = $request->passing_year;
            $employeeEducation->cgpa    = $request->cgpa;
            $employeeEducation->address = $request->address;
            $employeeEducation->institute_name = $request->institute_name;
            $employeeEducation->group_name = $request->group_name;
//        $employeeEducation->status  = $request->status;
            $employeeEducation->save();
            return ViewHelper::returnSuccessMessage('Employee Education Info saved successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeEducation $employeeEducation/*string $id*/)
    {
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax([
            'data' => $employeeEducation,
            'educationDegreeNames'   => EducationDegreeName::where(['status' => 1])->get(['id', 'degree_name']),
            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
        ], 'frontend.employee.include-edit-forms.education');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employeeEducation = EmployeeEducation::find($id);
        if (!$employeeEducation)
        {
            return ViewHelper::returEexceptionError('Employee Education Info not found.');
        }
        $validator = Validator::make($request->all(), [
            'passing_year'  => 'required',
            'university_name_id'  => 'required',
        ]);

        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        try {
//            $employeeEducation = new EmployeeEducation();
            $employeeEducation->user_id = ViewHelper::loggedUser()->id;
            $employeeEducation->education_degree_name_id    = $request->education_degree_name_id;
            $employeeEducation->university_name_id  = $request->university_name_id;
            $employeeEducation->field_of_study_id   = $request->field_of_study_id;
            $employeeEducation->main_subject_id = $request->main_subject_id;
            $employeeEducation->starting_date   = $request->starting_date;
            $employeeEducation->ending_date = $request->ending_date;
            $employeeEducation->passing_year    = $request->passing_year;
            $employeeEducation->cgpa    = $request->cgpa;
            $employeeEducation->address = $request->address;
            $employeeEducation->institute_name = $request->institute_name;
            $employeeEducation->group_name = $request->group_name;
//        $employeeEducation->status  = $request->status;
            $employeeEducation->save();
            return ViewHelper::returnSuccessMessage('Employee Education Info updated successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeEducation $employeeEducation)
    {
        if ($employeeEducation)
        {
            $employeeEducation->delete();
            Toastr::success('Employee Education Info deleted successfully.');
        } else {
            Toastr::error('Employee Education Info not found.');
        }
        return back();
    }
}
