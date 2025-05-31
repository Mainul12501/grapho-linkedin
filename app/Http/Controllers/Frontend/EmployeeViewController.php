<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeViewController extends Controller
{
    public function employeeHome()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.home.home');
    }
    public function showJobs()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.jobs.show-jobs');
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
        return ViewHelper::checkViewForApi([], 'frontend.employee.base-functionalities.my-profile');
    }
    public function myNotifications()
    {
        return ViewHelper::checkViewForApi([], 'frontend.employee.base-functionalities.my-notifications');
    }
}
