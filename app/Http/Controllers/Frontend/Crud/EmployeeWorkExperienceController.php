<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeWorkExperience;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EmployeeWorkExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'company_name' => 'required',
        ]);
        try {
            $workExperience = new EmployeeWorkExperience();
            $workExperience->user_id    = auth()->id();
            $workExperience->title  = $request->title;
            $workExperience->company_name   = $request->company_name;
            $workExperience->company_logo   = imageUpload($request->file('company_logo'), 'work-exp', 'work-exp', 60, 60, $workExperience->company_logo ?? null);
            $workExperience->position   = $request->position;
            $workExperience->job_responsibilities   = $request->job_responsibilities;
            $workExperience->start_date = $request->start_date;
            if ($request->is_working_currently != 'on')
                $workExperience->end_date   = $request->end_date;
            $workExperience->office_address = $request->office_address;
            $workExperience->duration   = ViewHelper::getDurationAmongTwoDates($request->start_date, $request->end_date, 'years', $request->is_working_currently == 'on');
            $workExperience->is_working_currently   = $request->is_working_currently == 'on' ? 1 : 0;
            $workExperience->job_type   = $request->job_type;
            $workExperience->status   = 1;
            $workExperience->save();
            return ViewHelper::returnSuccessMessage('Experience Created Successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeWorkExperience $employeeWorkExperience/*, string $id*/)
    {
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax($employeeWorkExperience);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeWorkExperience $employeeWorkExperience/*, string $id*/)
    {
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax(['data' => $employeeWorkExperience], 'frontend.employee.include-edit-forms.employee-work-experience');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $workExperience = EmployeeWorkExperience::findOrFail($id);
        if ($workExperience->user_id != auth()->id())
            return ViewHelper::returEexceptionError('You are not authorized to update this experience.');
        if (!$workExperience)
            return ViewHelper::returEexceptionError('Work Experience Data not found.');
        $request->validate([
            'title' => 'required',
            'company_name' => 'required',
        ]);
        try {
//            $workExperience = new EmployeeWorkExperience();
            $workExperience->user_id    = auth()->id();
            $workExperience->title  = $request->title;
            $workExperience->company_name   = $request->company_name;
            $workExperience->company_logo   = imageUpload($request->file('company_logo'), 'work-exp', 'work-exp', 60, 60, $workExperience->company_logo ?? null);
            $workExperience->position   = $request->position;
            $workExperience->job_responsibilities   = $request->job_responsibilities;
            $workExperience->start_date = $request->start_date;
            if ($request->is_working_currently != 'on')
                $workExperience->end_date   = $request->end_date;
            $workExperience->office_address = $request->office_address;
            $workExperience->duration   = ViewHelper::getDurationAmongTwoDates($request->start_date, $request->end_date, 'years', $request->is_working_currently == 'on');
            $workExperience->is_working_currently   = $request->is_working_currently == 'on' ? 1 : 0;
            $workExperience->job_type   = $request->job_type;
            $workExperience->status   = 1;
            $workExperience->save();
            return ViewHelper::returnSuccessMessage('Experience Created Successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(/*string $id*/EmployeeWorkExperience $employeeWorkExperience)
    {
        try {
            $employeeWorkExperience->delete();
            return ViewHelper::returnSuccessMessage('Experience deleted Successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
        return back();
    }
}
