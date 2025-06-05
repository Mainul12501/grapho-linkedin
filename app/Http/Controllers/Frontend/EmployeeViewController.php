<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeWorkExperience;
use App\Models\Backend\JobTask;
use Illuminate\Http\Request;

class EmployeeViewController extends Controller
{
    public function employeeHome()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.home.home');
    }
    public function showJobs(Request $request)
    {
        $data = [
            'jobTasks'  => JobTask::where(['status' => 1])->get(),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.show-jobs');
    }
    public function mySavedJobs()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.jobs.my-saved-jobs');
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
}
