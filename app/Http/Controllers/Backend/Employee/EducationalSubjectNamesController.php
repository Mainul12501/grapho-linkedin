<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Backend\EducationSubjectName;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\UniversityName;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EducationalSubjectNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employee-management.educational-subject-names.index', ['educationalSubjectNames' => EducationSubjectName::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employee-management.educational-subject-names.create', [
            'isShown'   => false,
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'field_of_study_id' => 'required',
            'subject_name' => 'required|string|max:255',
        ]);
        $educationSubjectName = EducationSubjectName::createOrUpdateEducationalSubjectName($request);
        if ($educationSubjectName)
        {
            Toastr::success('Educational Subject created successfully.');
            return redirect()->route('educational-subject-names.index');
        }
        else
        {
            Toastr::error('Educational Subject creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employee-management.educational-subject-names.create', [
            'isShown'   => true,
            'educationalSubjectName' => EducationSubjectName::findOrFail($id),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employee-management.educational-subject-names.create', [
            'isShown'   => false,
            'educationalSubjectName' => EducationSubjectName::findOrFail($id),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EducationSubjectName $educationSubjectName)
    {
        $request->validate([
            'field_of_study_id' => 'required',
            'subject_name' => 'required|string|max:255',
        ]);
        $educationalSubjectName = EducationSubjectName::createOrUpdateEducationalSubjectName($request, $educationSubjectName);
        if ($educationalSubjectName)
        {
            Toastr::success('Educational Subject updated successfully.');
            return redirect()->route('university-names.index');
        }
        else
        {
            Toastr::error('Educational Subject creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $educationSubjectName = EducationSubjectName::findOrFail($id);
        $educationSubjectName->delete();
        Toastr::success('Educational Subject deleted successfully.');
        return back();
    }
}
