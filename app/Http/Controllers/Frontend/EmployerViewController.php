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
use App\Models\Backend\SubscriptionPlan;
use App\Models\Backend\UniversityName;
use App\Models\Backend\UserProfileView;
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
            'employees' => User::where(['user_type' => 'employee', 'is_open_for_hire' => 1])->take(3)->get(['id', 'name', 'profile_title', 'address', 'profile_image']),
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
        $data = [
            'jobTasks'  => JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->get(['id', 'job_title']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.my-applicants');
        return view('frontend.employer.jobs.my-applicants');
    }
    public function myJobApplicants(JobTask $jobTask, Request $request)
    {
//        if (!isset($request->status))
//        {
//            return redirect(route('employer.my-job-applicants', ['jobTask' => $jobTask->id, 'status' => 'pending']));
//        }
        $applicants = $jobTask->employeeAppliedJobs()->with(['user']);
        $pendingApplicants = $applicants->where(['status' => 'pending'])->get();
        $approvedApplicants = $applicants->where(['status' => 'approved'])->get();
        $rejectedApplicants = $applicants->where(['status' => 'rejected'])->get();
        $shortListedApplicants = $applicants->where(['status' => 'shortlisted'])->get();
        $this->data = [
            'jobTask'   => $jobTask,
//            'applicants' => $jobTask->employeeAppliedJobs()->where(['status' => 'pending'])->with(['user'])->get(),
            'pendingApplicants' => $pendingApplicants,
            'approvedApplicants' => $approvedApplicants,
            'rejectedApplicants' => $rejectedApplicants,
            'shortListedApplicants' => $shortListedApplicants,
        ];
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax($this->data, 'frontend.employer.jobs.my-job-applicants');
        return view('frontend.employer.jobs.my-job-applicants');
    }
    public function headHunt(Request $request)
    {
        $employees = User::query();
        if (isset($request->job_type))
        {

        }
        if (isset($request->job_location))
        {

        }
        if (isset($request->university_name))
        {

        }
        if (isset($request->industry))
        {

        }
        if (isset($request->field_of_study))
        {

        }
        if (isset($request->skill))
        {

        }
        $employees = $employees->where(['user_type' => 'employee', 'is_open_for_hire' => 1])->get(['id', 'name', 'profile_title', 'address', 'profile_image']);

        $data = [
            'employees' => $employees,
            'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
            'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'jobLocations' => JobLocationType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name', 'slug']),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name', 'slug']),
            'skillCategories' => SkillsCategory::where(['status' => 1])->get(['id', 'category_name', 'slug']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.head-hunt');
        return view('frontend.employer.jobs.head-hunt');
    }
    public function employeeProfile($userId)
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser)
        {
            if ($loggedUser->user_type == 'employer')
            {
                $existProfileView = UserProfileView::where(['employee_id' => $userId, 'employer_id' => $loggedUser->id, 'viewed_by' => 'employer'])->first();
                if (!$existProfileView)
                {
                    $newProfileView = new UserProfileView();
                    $newProfileView->employee_id    = $userId;
                    $newProfileView->employer_id    = $loggedUser->id;
                    $newProfileView->viewed_by    = 'employer';
                    $newProfileView->employer_company_id    = $loggedUser?->employerCompany?->id;
                    $newProfileView->save();
                }
            }
        }
        $employee = User::with('employeeEducations', 'employeeDocuments', 'employeeWorkExperiences')->find($userId);
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax(['employeeDetails' => $employee],'frontend.employer.profile.employer-profile');
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

    public function changeSubEmployerStatus(User $user, $status)
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser->id == $user->id) {
            return ViewHelper::returEexceptionError('You can not change your own status');
        }
        if ($user->user_type != 'sub_employer' || $user->user_id != $loggedUser->id) {
            return ViewHelper::returEexceptionError('Invalid user');
        }
        try {
            $user->employer_agent_active_status = $status;
            $user->save();
            return ViewHelper::returnSuccessMessage('Sub employer status updated successfully');
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
    }

    public function changeEmployeeJobApplicationStatus(Request $request, User $user, JobTask $jobTask, $status = 'pending')
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser->id != $jobTask->user_id) {
            return ViewHelper::returEexceptionError('You are not authorized to change this status');
        }
        try {
            $appliedJob = $jobTask->employeeAppliedJobs()->where(['user_id' => $user->id])->first();
            if (!$appliedJob) {
                return ViewHelper::returEexceptionError('Job application not found');
            }

//            if ($status == 'shortlisted') {
//                $appliedJob->is_shortlisted = 1;
//            } else {
//            }
            $appliedJob->status = $status;
            $appliedJob->save();
            return ViewHelper::returnSuccessMessage('Employee job application status updated successfully');
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
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
            $company->founded_on = /*date('Y-m-d', strtotime($request->founded_on)) ?? null*/ $request->founded_on ?? $company->founded_on;
            $company->total_employees = (int)$request->total_employees ?? ( $company->total_employees ?? 0);
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

    public function deleteSubEmployer(User $user)
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser->id == $user->id) {
            return ViewHelper::returEexceptionError('You can not delete your own account');
        }
        if ($user->user_type != 'sub_employer' || $user->user_id != $loggedUser->id) {
            return ViewHelper::returEexceptionError('Invalid user');
        }
        try {
            $user->delete();
            return ViewHelper::returnSuccessMessage('Sub employer deleted successfully');
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
    }

    public function employerSubscriptions()
    {
        $this->data = [
            'loggedUser'    => ViewHelper::loggedUser(),
            'subscriptionPlans' => SubscriptionPlan::where(['status' => 1])->get()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.my-subscriptions');
        return \view('frontend.employer.config.my-subscriptions');
    }
}
