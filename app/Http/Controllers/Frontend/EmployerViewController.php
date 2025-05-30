<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployerViewController extends Controller
{
    public function employerHome()
    {
        return view('frontend.employer.home.home');
    }
    public function myJobs()
    {
        return view('frontend.employer.jobs.my-jobs');
    }
    public function myJobWiseApplicants()
    {
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
