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
use App\Models\Backend\Post;
use App\Models\Backend\SkillsCategory;
use App\Models\Backend\SubscriptionPlan;
use App\Models\Backend\UniversityName;
use App\Models\Backend\UserProfileView;
use App\Models\Backend\WebNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EmployerViewController extends Controller
{
    protected array $data = [];
    public function employerHome(Request $request)
    {
        $posts = Post::query()->latest();
        if (isset($request->start_number))
            $posts  = $posts->skip($request->start_number)->take(10);
        $posts = $posts->where(['status' => 1, 'user_type' => 'employer'])->with(['employer' => function ($employer) {
            $employer->select('id', 'name', 'employer_company_id')->with(['employerCompany' => function ($employerCompany) {
                $employerCompany->select('id', 'name', 'logo');
            }]);
        }])->get();
        foreach ($posts as $post)
        {
            $post['follow_history_status'] = ViewHelper::checkFollowHistory($post->user_id, ViewHelper::loggedUser()->id) ?? false;
        }
//        return response()->json($posts);
//        return $posts;
        if (str()->contains(url()->current(), '/api/'))
        {
            return  response()->json($posts);
        }
        if ($request->ajax() )
        {
            return \view('frontend.employer.include-edit-forms.home-append', ['posts' => $posts])->render();
        }
        $data = [

        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.home');
        return view('frontend.employer.home.home', $data);
    }

    public function dashboard()
    {
        $data = [
            'jobTasks'  => JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->paginate(10),
            'employees' => User::where(['user_type' => 'employee', 'is_open_for_hire' => 1])->take(3)->get(['id', 'name', 'profile_title', 'address', 'profile_image']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.dashboard');
        return view('frontend.employer.home.dashboard', $data);
    }
    public function myJobs(Request $request)
    {
        if ($request->has('job_status'))
        {
            if ($request->job_status == 'closed')
            {
                $jobs = JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 0])->get();
            } else {
                $jobs = JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->get();
            }
        } else {
            $jobs = JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->get();
        }
        $data = [
            'jobTypes'  => JobType::where(['status' => 1])->get(['id', 'name']),
            'jobLocations'  => JobLocationType::where(['status' => 1])->get(['id', 'name']),
            'universityNames'   => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies'   => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
            'skillCategories'   => SkillsCategory::where(['status' => 1])->get(['id', 'category_name']),
            'publishedJobs' => $jobs,
            'industries'    => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
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
        $applicants = $jobTask->employeeAppliedJobs()->with(['user'])->get();
        $pendingApplicants = $applicants->where('status', 'pending');
        $approvedApplicants = $applicants->where('status', 'approved');
        $rejectedApplicants = $applicants->where('status', 'rejected');
        $shortListedApplicants = $applicants->where('status', 'shortlisted');
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
        $employees = User::query()->with([
            'universityName',
            'industry',
            'fieldOfStudy',
            'jobTypes',
            'jobLocationTypes'
        ]);

        // Helper function to ensure array input
        $ensureArray = function ($value) {
            if (empty($value)) return [];
            // In the new Blade, it seems values are sent as a single string of comma-separated values.
            // Let's handle that case. If the value is a string, split it. Otherwise, assume it's an array.
            if (is_string($value)) {
                return explode(',', $value);
            }
            return is_array($value) ? $value : [$value];
        };

        // Get all filters from the request
        $filters = $request->input('filters', []);

        // Workplace Type (Job Type) filter
        if (isset($filters['job_type']) && !empty($filters['job_type'])) {
            $jobTypes = $ensureArray($filters['job_type']);
            $employees = $employees->whereHas('jobTypes', function($query) use ($jobTypes) {
                $query->whereIn('slug', $jobTypes);
            });
        }

        // University filter
        if (isset($filters['university_name']) && !empty($filters['university_name'])) {
            $universities = $ensureArray($filters['university_name']);
            $employees = $employees->whereHas('universityName', function($q) use ($universities) {
                $q->whereIn('slug', $universities);
            });
        }

        // District filter
        if (isset($filters['location']) && !empty($filters['location'])) {
            $districts = $ensureArray($filters['location']);
            $employees = $employees->whereIn('district', $districts);
        }

        $employees = $employees->where(['user_type' => 'employee', 'is_open_for_hire' => 1])->select(['id', 'name', 'profile_title', 'address', 'profile_image'])->paginate(21);

        $data = [
            'employees' => $employees,
            'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name', 'slug']),
            'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
            'jobLocations' => JobLocationType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name', 'slug']),
            'skillCategories' => SkillsCategory::where(['status' => 1])->with('skills')->get(['id', 'category_name', 'slug']),
        ];

        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.head-hunt');
    }
    public function headHuntBackup(Request $request)
    {
        $employees = User::query()->with([
            'universityName',
            'industry',
            'fieldOfStudy',
            'jobTypes',
            'jobLocationTypes'
        ]);

        // Helper function to ensure array input
        $ensureArray = function ($value) {
            if (empty($value)) return [];
            return is_array($value) ? $value : [$value];
        };

// Search text filter
        if ($request->filled('search_text')) {
            $searchText = $request->input('search_text');
            $employees = $employees->where(function($query) use ($searchText) {
                $query->where('name', 'like', "%$searchText%")
                    ->orWhereHas('universityName', function($q) use ($searchText) {
                        $q->where('name', 'like', "%$searchText%");
                    })
                    ->orWhereHas('industry', function($q) use ($searchText) {
                        $q->where('name', 'like', "%$searchText%");
                    })
                    ->orWhereHas('fieldOfStudy', function($q) use ($searchText) {
                        $q->where('field_name', 'like', "%$searchText%");
                    })
                    ->orWhereHas('jobTypes', function($q) use ($searchText) {
                        $q->where('name', 'like', "%$searchText%");
                    })
                    ->orWhereHas('jobLocationTypes', function($q) use ($searchText) {
                        $q->where('name', 'like', "%$searchText%");
                    });
            });
        }

        if ($request->filled('gender'))
        {
            $employees = $employees->where('gender', $request->gender);
        }
        if ($request->filled('district'))
        {
            $employees = $employees->where('district', $request->district);
        }

        // CGPA filter (minimum value)
        if ($request->filled('cgpa')) {
            $minCgpa = (float)$request->input('cgpa');
            $employees = $employees->whereHas('employeeEducations', function($query) use ($minCgpa) {
                $query->where('cgpa', '>=', $minCgpa)
                    ->orderBy('cgpa', 'desc'); // Get the highest CGPA for each user
            });
        }

// Experience filter (minimum years)
        if ($request->filled('experience')) {
            $minExperience = (float)$request->input('experience');
            $employees = $employees->whereHas('employeeWorkExperiences', function($query) use ($minExperience) {
                $query->select('user_id')
                    ->groupBy('user_id')
                    ->havingRaw('SUM(duration) >= ?', [$minExperience]);
            });
        }

// Job Type filter
        if ($request->filled('job_type')) {
            $jobTypes = $ensureArray($request->input('job_type'));
            $employees = $employees->where(function($query) use ($jobTypes) {
                $query->whereHas('jobTypes', function($q) use ($jobTypes) {
                    $q->whereIn('slug', $jobTypes);
                })->orWhereDoesntHave('jobTypes');
            });
        }

// Job Location filter
        if ($request->filled('job_location')) {
            $jobLocations = $ensureArray($request->input('job_location'));
            $employees = $employees->where(function($query) use ($jobLocations) {
                $query->whereHas('jobLocationTypes', function($q) use ($jobLocations) {
                    $q->whereIn('slug', $jobLocations);
                })->orWhereDoesntHave('jobLocationTypes');
            });
        }

// University filter
        if ($request->filled('university_name')) {
            $universities = $ensureArray($request->input('university_name'));
            $employees = $employees->where(function($query) use ($universities) {
                $query->whereHas('universityName', function($q) use ($universities) {
                    $q->whereIn('slug', $universities);
                })->orWhereDoesntHave('universityName');
            });
        }

// Industry filter
        if ($request->filled('industry')) {
            $industries = $ensureArray($request->input('industry'));
            $employees = $employees->where(function($query) use ($industries) {
                $query->whereHas('industry', function($q) use ($industries) {
                    $q->whereIn('slug', $industries);
                })->orWhereDoesntHave('industry');
            });
        }

// Field of Study filter
        if ($request->filled('field_of_study')) {
            $fields = $ensureArray($request->input('field_of_study'));
            $employees = $employees->where(function($query) use ($fields) {
                $query->whereHas('fieldOfStudy', function($q) use ($fields) {
                    $q->whereIn('slug', $fields);
                })->orWhereDoesntHave('fieldOfStudy');
            });
        }

// Skills filter
        if ($request->filled('skills')) {
            $skills = $ensureArray($request->input('skills'));
            $employees = $employees->whereHas('skills', function($query) use ($skills) {
                $query->whereIn('slug', $skills);
            });
        }

        $employees = $employees->where(['user_type' => 'employee', 'is_open_for_hire' => 1])->select(['id', 'name', 'profile_title', 'address', 'profile_image'])->paginate(21);

        $data = [
            'employees' => $employees,
            'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
            'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'jobLocations' => JobLocationType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name', 'slug']),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name', 'slug']),
            'skillCategories' => SkillsCategory::where(['status' => 1])->with('skills')->get(['id', 'category_name', 'slug']),
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
            $webNotification = new WebNotification();
            $webNotification->viewer_id = $loggedUser->id;
            $webNotification->viewed_user_id = $userId;
            $webNotification->notification_type = 'view_profile';
            $webNotification->msg = "$loggedUser->name have viewed your profile.";
            $webNotification->save();
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

    public function changeEmployeeJobApplicationStatus(Request $request, JobTask $jobTask, User $user,  $status = 'pending')
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
            $company->bin_number = $request->bin_number ?? $company->bin_number;
            $company->trade_license_number = $request->trade_license_number ?? $company->trade_license_number;
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
            'subscriptionPlans' => SubscriptionPlan::where(['status' => 1, 'subscription_for' => 'employer'])->get()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.my-subscriptions');
        return \view('frontend.employer.config.my-subscriptions');
    }
}
