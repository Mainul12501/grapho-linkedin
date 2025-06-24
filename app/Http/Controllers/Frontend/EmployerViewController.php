<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\JobLocationType;
use App\Models\Backend\JobTask;
use App\Models\Backend\JobType;
use App\Models\Backend\SkillsCategory;
use App\Models\Backend\UniversityName;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployerViewController extends Controller
{
    public function employerHome()
    {
        $data = [
            'jobTasks'  => JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->get(),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.home');
        return view('frontend.employer.home.home', $data);
    }
    public function myJobs()
    {
        $data = [
            'jobTypes'  => JobType::where(['status' => 1])->get(['id', 'name']),
            'jobLocations'  => JobLocationType::where(['status' => 1])->get(['id', 'name']),
            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
            'skillCategories'   => SkillsCategory::where(['status' => 1])->get(['id', 'category_name']),
            'publishedJobs' => JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->get(),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.my-jobs');
        return view('frontend.employer.jobs.my-jobs', $data);
    }
    public function myJobWiseApplicants()
    {
        $data = [];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.my-applicants');
        return view('frontend.employer.jobs.my-applicants');
    }
    public function myJobApplicants()
    {
        return view('frontend.employer.jobs.my-job-applicants');
    }
    public function headHunt()
    {
        return view('frontend.employer.jobs.head-hunt');
    }
    public function employeeProfile()
    {
        return view('frontend.employer.profile.employer-profile');
    }
    public function employerUserManagement()
    {
        return view('frontend.employer.config.users');
    }
    public function settings()
    {
        return view('frontend.employer.config.settings');
    }
    public function companyProfile()
    {
        return view('frontend.employer.config.company-profile');
    }
}
