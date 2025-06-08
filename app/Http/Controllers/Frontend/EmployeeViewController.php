<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Crud\JobTaskController;
use App\Models\Backend\EmployeeAppliedJob;
use App\Models\Backend\EmployeeWorkExperience;
use App\Models\Backend\JobTask;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use PHPUnit\Util\PHP\Job;

class EmployeeViewController extends Controller
{
    public function employeeHome()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.home.home');
    }
    public function showJobs(Request $request)
    {
        $jobTasks = JobTask::where(['status' => 1])->get();
        if (isset($request->job_task))
        {
            $singleJobTask  = JobTask::find($request->job_task);
        } else {
            $singleJobTask  = $jobTasks[0];
        }
        $getJobSaveApplyInfo = JobTaskController::getJobSaveApplyInfo($singleJobTask->id);
        $data = [
            'jobTasks'  => $jobTasks,
            'singleJobTask' => $singleJobTask,
            'isSaved'   => $getJobSaveApplyInfo['isSaved'],
            'isApplied'   => $getJobSaveApplyInfo['isApplied'],
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.show-jobs');
    }
    public function mySavedJobs()
    {
        $loggedUser = ViewHelper::loggedUser();
        $data = $loggedUser ? [
            'savedJobs' => $loggedUser->employeeSavedJobs ?? [],
        ] : [];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.my-saved-jobs');
    }
    public function myApplications()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.jobs.my-applications');
    }
    public function myProfileViewers()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.base-functionalities.profile-viewers');
    }
    public function mySubscriptions()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.base-functionalities.my-subscriptions');
    }
    public function settings()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.base-functionalities.settings');
    }
    public function myProfile()
    {
        $data = [
            'workExperiences'    => EmployeeWorkExperience::where(['user_id' => auth()->id(), 'status' => 1])->get(),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.my-profile');
    }
    public function myNotifications()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.base-functionalities.my-notifications');
    }

    public function saveJob(Request $request, JobTask $jobTask)
    {
        $user = ViewHelper::loggedUser();
        if (isset($jobTask) && $user)
        {
            $user->employeeSavedJobs()->sync($jobTask->id);
            $data = [
                'status'    => 'success',
                'msg'   => 'Job Saved successfully.'
            ];
        } else {
            $data = [
                'status'    => 'error',
                'msg'   => 'Job or User Not found.'
            ];
        }

        return ViewHelper::returnDataForAjaxAndApi($data);
    }

    public function applyJob(Request $request, JobTask $jobTask)
    {
//        return $jobTask;
        $loggedUser = ViewHelper::loggedUser();
        if ($jobTask && $loggedUser)
        {
            try {
                $employeeAppliedJob = new EmployeeAppliedJob();
                $employeeAppliedJob->user_id = $loggedUser->id;
                $employeeAppliedJob->job_task_id = $jobTask->id;
                $employeeAppliedJob->status = 'pending';
                $employeeAppliedJob->save();
                return ViewHelper::returnSuccessMessage('You applied for this job successfully.');
            } catch (\Exception $exception)
            {
                return ViewHelper::returEexceptionError($exception->getMessage());
            }
        } else {
            Toastr::error('Job or User not found.');
            return ViewHelper::returEexceptionError('Job or User not found.');
        }
    }
}
