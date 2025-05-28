<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Http\Controllers\Controller;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\UniversityName;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class UniversityNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employee-management.university-names.index', ['universityNames' => UniversityName::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employee-management.university-names.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'name' => 'required|string|max:255',
        ]);
        $universityName = UniversityName::createOrUpdateUniversityNames($request);
        if ($universityName)
        {
            Toastr::success('University Name created successfully.');
            return redirect()->route('university-names.index');
        }
        else
        {
            Toastr::error('University Name creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employee-management.university-names.create', [
            'isShown'   => true,
            'universityName' => UniversityName::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employee-management.university-names.create', [
            'isShown'   => false,
            'universityName' => UniversityName::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UniversityName $universityName)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $universityName = UniversityName::createOrUpdateUniversityNames($request, $universityName);
        if ($universityName)
        {
            Toastr::success('University Name updated successfully.');
            return redirect()->route('university-names.index');
        }
        else
        {
            Toastr::error('University Name creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UniversityName $universityName)
    {
        $universityName->delete();
        Toastr::success('University Name deleted successfully.');
        return back();
    }
}
