<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Backend\EducationDegreeName;
use App\Models\Backend\FieldOfStudy;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class FieldOfStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employee-management.field-of-studies.index', ['fieldOfStudies' => FieldOfStudy::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employee-management.field-of-studies.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'field_name' => 'required|string|max:255',
        ]);
        $fieldOfStudy = FieldOfStudy::createOrUpdateFieldOfStudies($request);
        if ($fieldOfStudy)
        {
            Toastr::success('Study field created successfully.');
            return redirect()->route('field-of-studies.index');
        }
        else
        {
            Toastr::error('Study field creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employee-management.field-of-studies.create', [
            'isShown'   => true,
            'educationDegreeName' => FieldOfStudy::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employee-management.field-of-studies.create', [
            'isShown'   => false,
            'educationDegreeName' => FieldOfStudy::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FieldOfStudy $fieldOfStudy)
    {
        $request->validate([
            'field_name' => 'required|string|max:255',
        ]);
        $fieldOfStudy = FieldOfStudy::createOrUpdateFieldOfStudies($request, $fieldOfStudy);
        if ($fieldOfStudy)
        {
            Toastr::success('Study field updated successfully.');
            return redirect()->route('field-of-studies.index');
        }
        else
        {
            Toastr::error('Study field creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FieldOfStudy $fieldOfStudy)
    {
        $fieldOfStudy->delete();
        Toastr::success('Study field deleted successfully.');
        return back();
    }
}
