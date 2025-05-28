<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\Industry;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employer-management.industries.index', ['industries' => Industry::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employer-management.industries.create', [
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
        $industry = Industry::createOrUpdateIndustry($request);
        if ($industry)
        {
            Toastr::success('Industry created successfully.');
            return redirect()->route('industries.index');
        }
        else
        {
            Toastr::error('Industry creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employer-management.industries.create', [
            'isShown'   => true,
            'industry' => Industry::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employer-management.industries.create', [
            'isShown'   => false,
            'industry' => Industry::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $industry = Industry::createOrUpdateIndustry($request, $industry);
        if ($industry)
        {
            Toastr::success('Industry updated successfully.');
            return redirect()->route('industries.index');
        }
        else
        {
            Toastr::error('Industry creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        $industry->delete();
        Toastr::success('Industry deleted successfully.');
        return back();
    }
}
