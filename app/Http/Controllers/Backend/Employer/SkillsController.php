<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\Skill;
use App\Models\Backend\SkillsCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.employer-management.skills.index', ['skills' => Skill::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.employer-management.skills.create', [
            'isShown'   => false,
            'skillCategories' => SkillsCategory::where(['status' => 1])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'skills_category_id' => 'required',
            'skill_name' => 'required|string|max:255',
        ]);
        $skill = Skill::createOrUpdateSkill($request);
        if ($skill)
        {
            Toastr::success('skill created successfully.');
            return redirect()->route('skills.index');
        }
        else
        {
            Toastr::error('skill creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.employer-management.skills.create', [
            'isShown'   => true,
            'skill' => Skill::findOrFail($id),
            'skillCategories' => SkillsCategory::where(['status' => 1])->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.employer-management.skills.create', [
            'isShown'   => false,
            'skill' => Skill::findOrFail($id),
            'skillCategories' => SkillsCategory::where(['status' => 1])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'skills_category_id' => 'required',
            'skill_name' => 'required|string|max:255',
        ]);
        $skill = Skill::createOrUpdateSkill($request, $skill);
        if ($skill)
        {
            Toastr::success('skill updated successfully.');
            return redirect()->route('skills.index');
        }
        else
        {
            Toastr::error('skill creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        Toastr::success('skill deleted successfully.');
        return back();
    }
}
