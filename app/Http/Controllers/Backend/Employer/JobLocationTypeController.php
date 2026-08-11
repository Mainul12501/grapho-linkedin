<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\JobLocationType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class JobLocationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employer-management.job-location-types.index', ['jobLocationTypes' => JobLocationType::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employer-management.job-location-types.create', [
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
        $jobLocationType = JobLocationType::createOrUpdateJobLocationType($request);
        if ($jobLocationType)
        {
            Toastr::success('Job Location Type created successfully.');
            return redirect()->route('job-location-types.index');
        }
        else
        {
            Toastr::error('Job Location Type creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employer-management.job-location-types.create', [
            'isShown'   => true,
            'jobLocationType' => JobLocationType::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employer-management.job-location-types.create', [
            'isShown'   => false,
            'jobLocationType' => JobLocationType::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobLocationType $jobLocationType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $jobLocationType = JobLocationType::createOrUpdateJobLocationType($request, $jobLocationType);
        if ($jobLocationType)
        {
            Toastr::success('Job Location Type updated successfully.');
            return redirect()->route('job-location-types.index');
        }
        else
        {
            Toastr::error('Job Location Type creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobLocationType $jobLocationType)
    {
        $jobLocationType->delete();
        Toastr::success('Job Location Type deleted successfully.');
        return back();
    }
}
