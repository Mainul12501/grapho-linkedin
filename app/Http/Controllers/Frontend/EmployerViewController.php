<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\EmployerCompany;
use App\Models\Backend\EmployerCompanyCategory;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\Industry;
use App\Models\Backend\JobLocationType;
use App\Models\Backend\JobTask;
use App\Models\Backend\JobType;
use App\Models\Backend\SkillsCategory;
use App\Models\Backend\UniversityName;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EmployerViewController extends Controller
{
    protected array $data = [];
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
        $user = ViewHelper::loggedUser();
        $this->data = [
            'loggedUser'    =>  $user,
            'employerUsers' =>  User::where(['user_type' => 'sub_employer', 'user_id' => $user->id])->get(['id', 'name', 'email', 'mobile', 'profile_image', 'user_type', 'employer_agent_active_status']),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.users');
        return view('frontend.employer.config.users');
    }
    public function settings()
    {
        $this->data = [
            'loggedUser'    =>  ViewHelper::loggedUser(),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.settings');
        return view('frontend.employer.config.settings');
    }
    public function companyProfile()
    {
        $this->data = [
            'loggedUser'    =>  ViewHelper::loggedUser(),
            'companyDetails'    => EmployerCompany::where(['user_id' => ViewHelper::loggedUser()->id])->first(),
            'industries'    => Industry::where(['status' => 1])->get(['id', 'name']),
            'employerCompanyCategories'    => EmployerCompanyCategory::where(['status' => 1])->get(['id', 'category_name']),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.company-profile');
        return view('frontend.employer.config.company-profile');
    }
    public function updateSettings(Request $request)
    {
        $user = ViewHelper::loggedUser();
        $validator = Validator::make($request->all(), [
            'email' => [
                'email',
                $user->email == $request->email ? 'nullable' : 'unique:users',
            ],
            'mobile' => [$user->mobile == $request->mobile ? 'nullable' : 'unique:users'],
        ]);
        if ($validator->fails()) {
            return ViewHelper::returEexceptionError($validator->errors());
        }
        try {

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->mobile = $request->mobile ?? $user->mobile;
            $user->profile_image = imageUpload($request->file('profile_image'), 'profile_images', 'profile_images',150, 100, $user->profile_image);
            $user->save();
            return ViewHelper::returnSuccessMessage('User settings updated successfully');
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
    }

    public function updateCompanyInfo(EmployerCompany $company, Request $request)
    {
        $user = ViewHelper::loggedUser();
        $company = EmployerCompany::where(['user_id' => $user->id,])->first();
        if (!$company) {
            return ViewHelper::returEexceptionError('Company not found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'email',
                $company->email == $request->email ? 'nullable' : 'unique:employer_companies',
//                $company->email == $request->email ? 'nullable' : 'unique:users',
            ],
            'phone' => [$company->phone == $request->phone ? 'nullable' : 'unique:employer_companies', /*$company->phone == $request->phone ? 'nullable' : 'unique:users,mobile'*/],
        ]);
        if ($validator->fails()) {
            return ViewHelper::returEexceptionError($validator->errors());
        }
        try {
            $company->name = $request->name ?? $company->name;
            $company->email = $request->email ?? $company->email;
            $company->phone = $request->phone ?? $company->phone;
            $company->address = $request->address ?? $company->address;
            $company->website = $request->website ?? $company->website;
            $company->founded_on = /*date('Y-m-d', strtotime($request->founded_on)) ?? null*/ $request->founded_on;
            $company->total_employees = (int)$request->total_employees ?? 0;
            $company->industry_id = (int)$request->industry_id ?? 0;
            $company->employer_company_category_id = (int)$request->employer_company_category_id ?? 0;
            if ($request->hasFile('logo')) {
                $company->logo = imageUpload($request->file('logo'), 'employer_company_logos', 'employer_company_logos', 100, 100, $company->logo);
            }
//            if ($request->has('status')) {
//                $company->status = (int)$request->status;
//            }
            if ($request->has('company_overview')) {
//                $company->company_overview = strip_tags($request->company_overview);
                $company->company_overview = $request->company_overview;
            }
            $company->save();
            return ViewHelper::returnSuccessMessage('Company information updated successfully');

        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
    }

    public function createSubUser(Request $request)
    {
        $user = ViewHelper::loggedUser();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [ 'email', 'unique:users'],
            'mobile' => ['required', 'unique:users'],
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return ViewHelper::returEexceptionError($validator->errors());
        }
        if (User::where(['user_id' => $user->id, 'user_type' => 'sub_employer'])->count() >= 5) {
            return ViewHelper::returEexceptionError('You can not create more than 5 sub users');
        }
        try {
            $subUser = new User();
            $subUser->name = $request->name;
            $subUser->email = $request->email;
            $subUser->mobile = $request->mobile;
            $subUser->password = bcrypt($request->password);
            $subUser->user_type = 'sub_employer';
            $subUser->user_id = $user->id;
            $subUser->employer_company_id = $user->employer_company_id;
            $subUser->organization_name = $user->organization_name;
            $subUser->employer_agent_active_status = 'active';
            $subUser->save();
            return ViewHelper::returnSuccessMessage('Sub user created successfully');
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
    }
}
