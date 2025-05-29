<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\EmployerCompanyCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EmployerCompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employer-management.employer-company-categories.index', ['employerCompanyCategories' => EmployerCompanyCategory::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employer-management.employer-company-categories.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'category_name' => 'required|string|max:255',
        ]);
        $employerCompanyCategory = EmployerCompanyCategory::createOrUpdateEmployerCompanyCategory($request);
        if ($employerCompanyCategory)
        {
            Toastr::success('Employer Company Category created successfully.');
            return redirect()->route('employer-company-categories.index');
        }
        else
        {
            Toastr::error('Employer Company Category creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employer-management.employer-company-categories.create', [
            'isShown'   => true,
            'employerCompanyCategory' => EmployerCompanyCategory::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employer-management.employer-company-categories.create', [
            'isShown'   => false,
            'employerCompanyCategory' => EmployerCompanyCategory::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployerCompanyCategory $employerCompanyCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
        $employerCompanyCategory = EmployerCompanyCategory::createOrUpdateEmployerCompanyCategory($request, $employerCompanyCategory);
        if ($employerCompanyCategory)
        {
            Toastr::success('Employer Company Category updated successfully.');
            return redirect()->route('employer-company-categories.index');
        }
        else
        {
            Toastr::error('Employer Company Category creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployerCompanyCategory $employerCompanyCategory)
    {
        $employerCompanyCategory->delete();
        Toastr::success('Employer Company Category deleted successfully.');
        return back();
    }
}
