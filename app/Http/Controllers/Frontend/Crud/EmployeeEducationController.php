<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeEducation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

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
        $request->validate([
            'passing_year'  => 'required',
            'university_name_id'  => 'required',
        ]);
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
//        $employeeEducation->status  = $request->status;
        $employeeEducation->save();
        Toastr::success('Employee Education Info saved successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
