<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\JobType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employer-management.job-types.index', ['jobTypes' => JobType::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employer-management.job-types.create', [
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
        $jobType = JobType::createOrUpdateJobType($request);
        if ($jobType)
        {
            Toastr::success('Job Type created successfully.');
            return redirect()->route('job-types.index');
        }
        else
        {
            Toastr::error('Job Type creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employer-management.job-types.create', [
            'isShown'   => true,
            'jobType' => JobType::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employer-management.job-types.create', [
            'isShown'   => false,
            'jobType' => JobType::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobType $jobType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $jobType = JobType::createOrUpdateJobType($request, $jobType);
        if ($jobType)
        {
            Toastr::success('Job Type updated successfully.');
            return redirect()->route('job-types.index');
        }
        else
        {
            Toastr::error('Job Type creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobType $jobType)
    {
        $jobType->delete();
        Toastr::success('Job Type deleted successfully.');
        return back();
    }
}
