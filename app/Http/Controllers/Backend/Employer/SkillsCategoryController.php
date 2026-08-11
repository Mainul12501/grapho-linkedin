<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\EducationDegreeName;
use App\Models\Backend\SkillsCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SkillsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employer-management.skills-categories.index', ['skillsCategories' => SkillsCategory::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employer-management.skills-categories.create', [
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
        $skillsCategory = SkillsCategory::createOrUpdateSkillsCategory($request);
        if ($skillsCategory)
        {
            Toastr::success('Skill Category created successfully.');
            return redirect()->route('skills-categories.index');
        }
        else
        {
            Toastr::error('Skill Category creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employer-management.skills-categories.create', [
            'isShown'   => true,
            'skillCategory' => SkillsCategory::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employer-management.skills-categories.create', [
            'isShown'   => false,
            'skillCategory' => SkillsCategory::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SkillsCategory $skillsCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
        $skillsCategory = SkillsCategory::createOrUpdateSkillsCategory($request, $skillsCategory);
        if ($skillsCategory)
        {
            Toastr::success('Skill Category updated successfully.');
            return redirect()->route('skills-categories.index');
        }
        else
        {
            Toastr::error('Skill Category creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SkillsCategory $skillsCategory)
    {
        $skillsCategory->delete();
        Toastr::success('Skill Category deleted successfully.');
        return back();
    }
}
