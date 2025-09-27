<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeAppliedJob;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\Industry;
use App\Models\Backend\JobLocationType;
use App\Models\Backend\JobTask;
use App\Models\Backend\JobType;
use App\Models\Backend\SkillsCategory;
use App\Models\Backend\UniversityName;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
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
        $data = [
            'jobTypes'  => JobType::where(['status' => 1])->get(['id', 'name']),
            'jobLocations'  => JobLocationType::where(['status' => 1])->get(['id', 'name']),
            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
            'skillCategories'   => SkillsCategory::where(['status' => 1])->get(['id', 'category_name']),
            'publishedJobs' => JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->get(),
            'industries'    => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.create-jobs');
        return view('frontend.employer.jobs.create-jobs', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'job_title' => 'required'
        ]);
        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }
        try {
            //        $jobTask = JobTask::createOrUpdateJobTask($request);
            $jobTask = new JobTask();
            $jobTask->user_id = ViewHelper::loggedUser()->id;
            $jobTask->job_title = $request->job_title;
            $jobTask->job_type_id = $request->job_type_id;
            $jobTask->job_location_type_id = $request->job_location_type_id;
            $jobTask->industry_id = $request->industry_id;
            $jobTask->employer_company_id = ViewHelper::loggedUser()?->employerCompanies[0]?->id;
            $jobTask->is_custom_exp = $request->required_experience == 'custom' ? 1 : 0;
            $jobTask->required_experience = $request->required_experience == 'custom' ? $request->exp_range_start.'-'.$request->exp_range_end: $request->required_experience;
            $jobTask->job_pref_salary_payment_type = $request->job_pref_salary_payment_type;
            $jobTask->salary_amount = $request->salary_amount;
            $jobTask->salary_range_start = $request->salary_range_start;
            $jobTask->salary_range_end = $request->salary_range_end;
            $jobTask->description = $request->description;
            $jobTask->deadline = $request->deadline;
            $jobTask->cgpa = $request->cgpa;
            $jobTask->gender = $request->gender;
            $jobTask->require_sector_looking_for = json_encode($request->require_sector_looking_for);
            $jobTask->slug = str_replace(' ', '-', $request->job_title);
            $jobTask->save();


            if ($jobTask)
            {
                $jobTask->employerPrefferableUniversityNames()->sync($request->university_preference);
                $jobTask->employerPrefferableFieldOfStudyNames()->sync($request->field_of_study_preference);
                $jobTask->jobRequiredskills()->sync($request->required_skills);
            }
            return ViewHelper::returnSuccessMessage('Job Created Successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
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
    public function edit(JobTask  $jobTask/*string $id*/)
    {
        $data = [
            'jobTask' => $jobTask,
            'jobTypes'  => JobType::where(['status' => 1])->get(['id', 'name']),
            'industries'  => Industry::where(['status' => 1])->get(['id', 'name']),
            'jobLocations'  => JobLocationType::where(['status' => 1])->get(['id', 'name']),
            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
            'skillCategories'   => SkillsCategory::where(['status' => 1])->get(['id', 'category_name']),
        ];
        if (\request()->ajax())
        {
            return \view('frontend.employer.include-edit-forms.job-edit', $data)->render();
        } elseif (str()->contains(url()->current(), '/api/'))
        {
            return response()->json($data, 200);
        } else {
            return \view('frontend.employer.jobs.edit-jobs', $data);
        }

//        return \view('frontend.employer.jobs.edit-jobs', [
//            'jobTask' => $jobTask,
//            'jobTypes'  => JobType::where(['status' => 1])->get(['id', 'name']),
//            'industries'  => Industry::where(['status' => 1])->get(['id', 'name']),
//            'jobLocations'  => JobLocationType::where(['status' => 1])->get(['id', 'name']),
//            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
//            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
//            'skillCategories'   => SkillsCategory::where(['status' => 1])->get(['id', 'category_name']),
//        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobTask $jobTask/*string $id*/)
    {
//        return $request->all();
        $validator = Validator::make($request->all(),[
            'job_title' => 'required'
        ]);
        if ($validator->fails())
        {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        try {
            //        $jobTask = JobTask::createOrUpdateJobTask($request);
//            $jobTask = new JobTask();
            $jobTask->user_id = ViewHelper::loggedUser()->id;
            $jobTask->job_title = $request->job_title;
            $jobTask->job_type_id = $request->job_type_id;
            $jobTask->job_location_type_id = $request->job_location_type_id;
            $jobTask->industry_id = $request->industry_id;
            $jobTask->employer_company_id = ViewHelper::loggedUser()?->employerCompanies[0]?->id;
            $jobTask->is_custom_exp = $request->required_experience == 'custom' ? 1 : 0;
            $jobTask->required_experience = $request->required_experience == 'custom' ? $request->exp_range_start.'-'.$request->exp_range_end: $request->required_experience;
            $jobTask->job_pref_salary_payment_type = $request->job_pref_salary_payment_type;
            $jobTask->salary_amount = $request->salary_amount;
            $jobTask->salary_range_start = $request->salary_range_start;
            $jobTask->salary_range_end = $request->salary_range_end;
            $jobTask->description = $request->description;
            $jobTask->deadline = $request->deadline;
            $jobTask->cgpa = $request->cgpa;
            $jobTask->gender = $request->gender;
            $jobTask->status = $request->status == 'on' ? 1 : 0;
            $jobTask->require_sector_looking_for = json_encode($request->require_sector_looking_for);
            $jobTask->slug = str_replace(' ', '-', $request->job_title);
            $jobTask->save();


            if ($jobTask)
            {
                $jobTask->employerPrefferableUniversityNames()->sync($request->university_preference);
                $jobTask->employerPrefferableFieldOfStudyNames()->sync($request->field_of_study_preference);
                $jobTask->jobRequiredskills()->sync($request->required_skills);
            }
            return ViewHelper::returnRedirectWithMessage(route('employer.my-jobs'), 'success', 'Job Updated Successfully.');
//            return ViewHelper::returnSuccessMessage('Job Updated Successfully.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
        return back();
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
        if (isset($request->render) && $request->render == 1)
        {
            return \view('frontend.employee.include-edit-forms.job-details', ['singleJobTask' => $jobTask, 'isSaved' => $isSaved, 'isApplied' => $isApplied])->render();
        }
        if ($jobTask)
            return response()->json(['status' => 'success', 'job' => $jobTask, 'isSaved' => $isSaved, 'isApplied' => $isApplied]);
        else
            return response()->json(['status' => 'error', 'msg' => 'Job not found.']);
    }


}
