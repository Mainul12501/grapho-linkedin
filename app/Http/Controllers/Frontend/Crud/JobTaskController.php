<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeAppliedJob;
use App\Models\Backend\JobTask;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use phpseclib3\System\SSH\Agent\Identity;

class JobTaskController extends Controller
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
            'job_title' => 'required'
        ]);
//        $jobTask = JobTask::createOrUpdateJobTask($request);
        $jobTask = new JobTask();
        $jobTask->user_id = ViewHelper::loggedUser()->id;
        $jobTask->job_title = $request->job_title;
        $jobTask->job_type_id = $request->job_type_id;
        $jobTask->job_location_type_id = $request->job_location_type_id;
        $jobTask->employer_company_id = ViewHelper::loggedUser()?->employerCompanies[0]?->id;
        $jobTask->required_experience = $request->required_experience;
        $jobTask->job_pref_salary_payment_type = $request->job_pref_salary_payment_type;
        $jobTask->salary_amount = $request->salary_amount;
        $jobTask->salary_range_start = $request->salary_range_start;
        $jobTask->salary_range_end = $request->salary_range_end;
        $jobTask->description = $request->description;
        $jobTask->deadline = $request->deadline;
        $jobTask->require_sector_looking_for = json_encode($request->require_sector_looking_for);
        $jobTask->slug = str_replace(' ', '-', $request->job_title);
        $jobTask->save();


        if ($jobTask)
        {
            $jobTask->employerPrefferableUniversityNames()->sync($request->university_preference);
            $jobTask->employerPrefferableFieldOfStudyNames()->sync($request->university_preference);
            $jobTask->jobRequiredskills()->sync($request->required_skills);
        }
        Toastr::success('Job Created Successfully.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobTask $jobTask)
    {
        $jobTask->employerPrefferableUniversityNames()->detach();
        $jobTask->employerPrefferableFieldOfStudyNames()->detach();
        $jobTask->jobRequiredskills()->detach();
        $jobTask->delete();
        Toastr::success('Your Job Deleted sucessfully.');
        return back();
    }

    public function getJobDetails(Request $request,String $id)
    {
        $jobTask = JobTask::with(['jobType', 'jobLocationType', 'employerCompany'])->find($id);
        $isApplied = false;
        $isSaved = false;
        if (ViewHelper::loggedUser())
        {
            $user = ViewHelper::loggedUser();
            if ($user->roles[0]->id == 3 )
            {
                $savedJobsIds = $user->employeeSavedJobs->pluck('id')->toArray();
                $isSaved = in_array($id, $savedJobsIds);
                if (EmployeeAppliedJob::where(['user_id' => $user->id, 'job_task_id' => $id])->first())
                    $isApplied = true;
            }
        }
        if ($jobTask)
            return response()->json(['status' => 'success', 'job' => $jobTask, 'isSaved' => $isSaved, 'isApplied' => $isApplied]);
        else
            return response()->json(['status' => 'error', 'msg' => 'Job not found.']);
    }

    public static function getJobSaveApplyInfo($id)
    {
        $isSaved = false;
        $isApplied = false;
        if (ViewHelper::loggedUser())
        {
            $user = ViewHelper::loggedUser();
            if ($user->roles[0]->id == 3 )
            {
                $savedJobsIds = $user->employeeSavedJobs->pluck('id')->toArray();
                $isSaved = in_array($id, $savedJobsIds);
                if (EmployeeAppliedJob::where(['user_id' => $user->id, 'job_task_id' => $id])->first())
                    $isApplied = true;
            }
        }
        return [
            'isSaved'   => $isSaved,
            'isApplied'   => $isApplied,
        ];
    }
}
