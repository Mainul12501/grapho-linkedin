<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Crud\JobTaskController;
use App\Models\Backend\EducationDegreeName;
use App\Models\Backend\EmployeeAppliedJob;
use App\Models\Backend\EmployeeDocument;
use App\Models\Backend\EmployeeEducation;
use App\Models\Backend\EmployeeWorkExperience;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\JobTask;
use App\Models\Backend\SubscriptionPlan;
use App\Models\Backend\UniversityName;
use App\Models\Backend\UserProfileView;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use PHPUnit\Util\PHP\Job;

class EmployeeViewController extends Controller
{
    protected $data = [];
    public function employeeHome()
    {
        $data = [
            'totalSavedJobs'    => auth()->user()->employeeSavedJobs()->count() ?? 0,
            'totalAppliedApplications'    => auth()->user()->employeeAppliedJobs()->count() ?? 0,
            'totalViewedEmployers'    => auth()->user()->viewedEmployers()->count() ?? 0,
            'topJobsForEmployee'    => JobTask::where([
                'status' => 1
            ])->take(5)->latest()->get(),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.home.home');
        return \view('frontend.employee.home.home');
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
        $getJobSaveApplyInfo = ViewHelper::getJobSaveApplyInfo($singleJobTask->id);
        $data = [
            'jobTasks'  => $jobTasks,
            'singleJobTask' => $singleJobTask,
            'isSaved'   => $getJobSaveApplyInfo['isSaved'],
            'isApplied'   => $getJobSaveApplyInfo['isApplied'],
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.show-jobs');
        return \view('frontend.employee.jobs.show-jobs');
    }
    public function mySavedJobs()
    {
        $loggedUser = ViewHelper::loggedUser();
        $savedJobs  = $loggedUser->employeeSavedJobs;
        foreach ($savedJobs as $savedJob)
        {
            $savedJob->isApplied    = ViewHelper::getJobSaveApplyInfo($savedJob->id);
        }
        $data = $loggedUser ? [
            'savedJobs' => $savedJobs ?? [],
        ] : [];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.my-saved-jobs');
    }
    public function myApplications()
    {
        $user = ViewHelper::loggedUser();
//        return $user->employeeAppliedJobs;
        $data = [
//            'myApplications'    => $user->employeeAppliedJobs
//            'myApplications'    => $user->appliedJobs
            'myApplications'    => $user->appliedJobsWithJobDetails
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.my-applications');
    }
    public function myProfileViewers()
    {
        $user = ViewHelper::loggedUser();
        $profileViewerIds = UserProfileView::where(['employee_id' => $user->id, 'viewed_by' => 'employer'])->with('employerCompany')->get();
        $data = [
            'myProfileViewers'  => $profileViewerIds
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.profile-viewers');
        return \view('frontend.employee.base-functionalities.profile-viewers');
    }
    public function mySubscriptions()
    {
        $this->data = [
            'loggedUser'    => ViewHelper::loggedUser(),
            'subscriptionPlans' => SubscriptionPlan::where(['status' => 1])->get()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employee.base-functionalities.my-subscriptions');
        return \view('frontend.employee.base-functionalities.my-subscriptions');
    }
    public function settings()
    {
        $this->data = [
            'loggedUser'    => ViewHelper::loggedUser()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employee.base-functionalities.settings');
        return \view('frontend.employee.base-functionalities.settings');
    }
    public function myProfile()
    {
        $data = [
            'workExperiences'    => EmployeeWorkExperience::where(['user_id' => auth()->id(), 'status' => 1])->get(),
            'employeeEducations'    => EmployeeEducation::where(['user_id' => auth()->id(), 'status' => 1])->get(),
            'employeeDocuments'    => EmployeeDocument::where(['user_id' => auth()->id(), 'status' => 1])->get(),
            'employeeProfileDate'   => ViewHelper::loggedUser(),
            'educationDegreeNames'   => EducationDegreeName::where(['status' => 1])->get(['id', 'degree_name']),
            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.my-profile');
        return \view('frontend.employee.base-functionalities.my-profile');
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
            $user->employeeSavedJobs()->syncWithoutDetaching($jobTask->id);
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

        return ViewHelper::returnBackViewAndSendDataForApiAndAjax($data);
    }

    public function deleteSaveJob(Request $request, JobTask $jobTask)
    {
        if ($jobTask)
        {
            $user = ViewHelper::loggedUser();
            $user->employeeSavedJobs()->detach($jobTask->id);
            return ViewHelper::returnSuccessMessage('Job removed from my jobs.');
        } else {
            return ViewHelper::returEexceptionError('Job not found');
        }
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

    public function updateProfile(Request $request, User $user)
    {
//        return $request->all();
//        return $user;
        $validator = Validator::make($request->all(), [
            'email' => $user->email != $request->email ? 'unique:users' : '',
            'mobile' => $user->mobile != $request->mobile ? 'unique:users' : '',
        ]);
        if ($validator->fails())
        {
            Toastr::error($validator->errors());
            return back();
        }
        if (isset($request->prev_password) && isset($request->new_password))
        {
            if (!Hash::check($request->prev_password, $user->password))
            {
                return ViewHelper::returEexceptionError('Password Mismatch. Please provide correct password.');
            }
        }
        try {

            if ($user)
            {
                $user->profile_title    = $request->profile_title ?? $user->profile_title;
                $user->email    = $request->email ?? $user->email;
                $user->mobile    = $request->mobile ?? $user->mobile;
                $user->website    = $request->website ?? $user->website;
                if ($request->hasFile('profile_image'))
                {
                    $user->profile_image    = imageUpload($request->file('profile_image'), 'profile-image', 'profile_image', 200,200, $user->profile_image ?? null);
                }
                $user->address    = $request->address ?? $user->address;
                $user->save();
            }
            Toastr::success('Profile Info updated successfully.');
            return ViewHelper::returnResponseFromPostRequest(true,'Profile Info updated successfully.');
        } catch (\Exception $exception)
        {
            Toastr::error($exception->getMessage());
            return ViewHelper::returnResponseFromPostRequest(true, $exception->getMessage());
        }
        return back();
    }

}
