<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Backend\EducationDegreeName;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EducationDegreeNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employee-management.education-degree-names.index', ['educationDegreeNames' => EducationDegreeName::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employee-management.education-degree-names.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'degree_name' => 'required|string|max:255',
        ]);
        $educationDegreeName = EducationDegreeName::createOrUpdateEducationDegreeName($request);
        if ($educationDegreeName)
        {
            Toastr::success('Education Degree Name created successfully.');
            return redirect()->route('education-degree-names.index');
        }
        else
        {
            Toastr::error('Education Degree Name creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employee-management.education-degree-names.create', [
            'isShown'   => true,
            'educationDegreeName' => EducationDegreeName::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employee-management.education-degree-names.create', [
            'isShown'   => false,
            'educationDegreeName' => EducationDegreeName::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EducationDegreeName $educationDegreeName)
    {
        $request->validate([
            'degree_name' => 'required|string|max:255',
        ]);
        $educationDegreeName = EducationDegreeName::createOrUpdateEducationDegreeName($request, $educationDegreeName);
        if ($educationDegreeName)
        {
            Toastr::success('Education Degree Name updated successfully.');
            return redirect()->route('education-degree-names.index');
        }
        else
        {
            Toastr::error('Education Degree Name creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationDegreeName $educationDegreeName)
    {
        $educationDegreeName->delete();
        Toastr::success('Education Degree Name deleted successfully.');
        return back();
    }
}
