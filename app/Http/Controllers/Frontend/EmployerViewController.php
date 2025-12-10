<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Advertisement;
use App\Models\Backend\EmployerCompany;
use App\Models\Backend\EmployerCompanyCategory;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\Industry;
use App\Models\Backend\JobLocationType;
use App\Models\Backend\JobTask;
use App\Models\Backend\JobType;
use App\Models\Backend\Post;
use App\Models\Backend\SiteSetting;
use App\Models\Backend\SkillsCategory;
use App\Models\Backend\SubscriptionPlan;
use App\Models\Backend\UniversityName;
use App\Models\Backend\UserProfileView;
use App\Models\Backend\WebNotification;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmployerViewController extends Controller
{
    protected array $data = [];

    public function employerHome(Request $request)
    {
        $posts = Post::query()
            ->where(['status' => 1, 'user_type' => 'employer'])->orWhere('user_type' , 'employer')
            ->latest();

        if ($request->filled('start_number')) {
            $posts = $posts->skip($request->start_number);
        }

        if ($request->filled('search_text')) {
            $posts = $posts->whereHas('employer.employerCompany', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search_text . '%');
            });
        }

        $posts = $posts->with(['employer' => function ($query) {
            $query->select('id', 'name', 'employer_company_id')
                ->with(['employerCompany' => function ($query) {
                    $query->select('id', 'name', 'logo');
                }]);
        }])
            ->take(10)
            ->get();

        $isApiRequest = false;
        if (str()->contains(url()->current(), '/api/'))
        {
            $isApiRequest = true;
        }
        foreach ($posts as $post) {
            $post['follow_history_status'] = ViewHelper::checkFollowHistory($post->user_id, ViewHelper::loggedUser()->id) ?? false;
            if ($isApiRequest)
            $post['image_array'] = json_decode($post->images);
        }
//        return response()->json($posts);
//        return $posts;
        if (str()->contains(url()->current(), '/api/')) {
            return response()->json($posts);
        }
        if ($request->ajax()) {
            return \view('frontend.employer.include-edit-forms.home-append', ['posts' => $posts])->render();
        }
        $data = [
            'advertisements' => Advertisement::where(['status' => 1])->latest()->inRandomOrder()->paginate(10),
            'employees' => User::where(['user_type' => 'employee', 'is_open_for_hire' => 1])->take(5)->get(['id', 'name', 'profile_title', 'address', 'profile_image']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.home');
        return view('frontend.employer.home.home', $data);
    }

    public function dashboard()
    {
        // Load relationships efficiently
        $jobTasks = JobTask::with(['jobType', 'jobLocationType', 'employeeAppliedJobs'])
            ->where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])
            ->where('is_softly_deleted', 0)
            ->get()
            ->map(function ($job) {
                $job->type = 'job';
                $job->display_title = $job->job_title; // For unified access
                return $job;
            });

        $posts = Post::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])
            ->get()
            ->map(function ($post) {
                $post->type = 'post';
                $post->display_title = $post->title; // For unified access
                return $post;
            });

// Merge and sort
        $merged = $jobTasks->concat($posts)->sortByDesc('created_at')->values();

// Manual pagination
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $items = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $data = [
//            'jobTasks' => JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->where('is_softly_deleted', 0)->paginate(10),
//            'employees' => User::where(['user_type' => 'employee', 'is_open_for_hire' => 1])->take(3)->get(['id', 'name', 'profile_title', 'address', 'profile_image']),
            'paginatedData' => $paginatedData
        ];
        if (request()->ajax()) {
            return view('frontend.employer.home.activity-content', $data)->render();
        }
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.dashboard');
        return view('frontend.employer.home.dashboard', $data);
    }

    public function myJobs(Request $request)
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser->user_type == 'employer')
            $jobUserId = $loggedUser->id;
        elseif ($loggedUser->user_type == 'sub_employer')
            $jobUserId = $loggedUser->user_id;
        if ($request->has('job_status')) {
            if ($request->job_status == 'closed') {
                $jobs = JobTask::where(['user_id' => $jobUserId, 'status' => 0])->latest()->where('is_softly_deleted', 0)->paginate(10);
            } else {
                $jobs = JobTask::where(['user_id' => $jobUserId, 'status' => 1])->latest()->where('is_softly_deleted', 0)->paginate(10);
            }
        } elseif (isset($request->search_text)) {
            $jobs = JobTask::where([
                'user_id' => $jobUserId,
                'status' => 1,

            ])->where('job_title', 'LIKE', "%{$request->search_text}%")->latest()->where('is_softly_deleted', 0)->paginate(10);
        } else {
            $jobs = JobTask::where(['user_id' => $jobUserId, 'status' => 1])->latest()->where('is_softly_deleted', 0)->paginate(10);
        }
        if (ViewHelper::checkIfRequestFromApi()) {
            foreach ($jobs as $job) {
                $job->total_applicants = $job->employeeAppliedJobs()->count();
            }
        }
        $data = [
            'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name']),
            'jobLocations' => JobLocationType::where(['status' => 1])->get(['id', 'name']),
            'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
            'skillCategories' => SkillsCategory::where(['status' => 1])->with(['skills' => function ($skills) {
                return $skills->select('id', 'skills_category_id', 'skill_name', 'slug')->where('status', 1);
            }])->get(['id', 'category_name']),
            'publishedJobs' => $jobs,
            'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.my-jobs');
        return view('frontend.employer.jobs.my-jobs', $data);
    }

    public function myJobWiseApplicants()
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
        $jobTasks = JobTask::where(['user_id' => ViewHelper::loggedUser()->id, 'status' => 1])->where('is_softly_deleted', 0)->get(['id', 'job_title']);
        if (ViewHelper::checkIfRequestFromApi()) {
            foreach ($jobTasks as $jobTask) {
                $jobTask->total_applicants = $jobTask->employeeAppliedJobs()->count() ?? 0;
            }
        }
        $data = [
            'jobTasks' => $jobTasks,
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
        $pendingApplicants = $applicants->where('status', 'pending')->values();
        $approvedApplicants = $applicants->where('status', 'approved')->values();
        $rejectedApplicants = $applicants->where('status', 'rejected')->values();
        $shortListedApplicants = $applicants->where('status', 'shortlisted')->values();
        $this->data = [
            'jobTask' => $jobTask,
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
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employer.dashboard'),  'error','Your account is blocked or has not approved yet. Please contact with Likewise.');
        }
        $employees = User::query()->with([
            'universityName' => function ($universityName) {
                $universityName->select('id', 'name', 'slug');
            },
            'industry',
            'fieldOfStudy',
            'jobTypes' => function ($jobType) {
                $jobType->select('id', 'name', 'slug');
            },
            'jobLocationTypes' => function ($jobLocationTypes) {
                $jobLocationTypes->select('id', 'name', 'slug');
            },
            'employeeSkills' => function ($skills) {
                $skills->select('id', 'skills_category_id', 'skill_name', 'slug');
            },
            'employeeWorkExperiences' => function ($employeeWorkExperiences) {
                $employeeWorkExperiences->select('id', 'user_id', 'title', 'duration');
            },
            'employeeEducations'
        ]);

        // Helper function to ensure array input
        $ensureArray = function ($value) {
            if (empty($value)) return [];

            // If it's a JSON string, decode it
            if (is_string($value) && (strpos($value, '[') === 0 || strpos($value, '{') === 0)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }
            }

            // If the value is a string with commas, split it
            if (is_string($value) && strpos($value, ',') !== false) {
                return array_map('trim', explode(',', $value));
            }

            return is_array($value) ? $value : [$value];
        };

        // Get all filters from the request
        $filters = $request->input('filters', []);

        // Base condition: only employees open for hire
        $employees = $employees->where(['user_type' => 'employee', 'is_open_for_hire' => 1]);

        // 1. Workplace Type (Job Type) filter
        if (isset($filters['job_type']) && !empty($filters['job_type'])) {
            $jobTypes = $ensureArray($filters['job_type']);
            if (!empty($jobTypes)) {
                $employees = $employees->whereHas('jobTypes', function ($query) use ($jobTypes) {
                    $query->whereIn('slug', $jobTypes);
                });
            }
        }

        // 2. University filter
        if (isset($filters['university_name']) && !empty($filters['university_name'])) {
            $universities = $ensureArray($filters['university_name']);
            if (!empty($universities)) {
                $employees = $employees->whereHas('universityName', function ($q) use ($universities) {
                    $q->whereIn('slug', $universities);
                });
            }
        }

        // 3. District/Location filter
        if (isset($filters['district']) && !empty($filters['district'])) {
            $districts = $ensureArray($filters['district']);
            if (!empty($districts)) {
                $employees = $employees->whereIn('district', $districts);
            }
        }

        // 4. Industry filter
        if (isset($filters['industry']) && !empty($filters['industry'])) {
            $industries = $ensureArray($filters['industry']);
            if (!empty($industries)) {
                $employees = $employees->whereHas('industry', function ($q) use ($industries) {
                    $q->whereIn('slug', $industries);
                });
            }
        }

        // 5. Field of Study filter
        if (isset($filters['field_of_study']) && !empty($filters['field_of_study'])) {
            $fieldOfStudies = $ensureArray($filters['field_of_study']);
            if (!empty($fieldOfStudies)) {
                $employees = $employees->whereHas('fieldOfStudy', function ($q) use ($fieldOfStudies) {
                    $q->whereIn('slug', $fieldOfStudies);
                });
            }
        }

        // 6. Skills filter
        if (isset($filters['skills']) && !empty($filters['skills'])) {
            $skills = $ensureArray($filters['skills']);
            if (!empty($skills)) {
                $employees = $employees->whereHas('employeeSkills', function ($q) use ($skills) {
                    $q->whereIn('slug', $skills);
                });
            }
        }

        // 7. Gender filter
        if (isset($filters['gender']) && !empty($filters['gender'])) {
            $genders = $ensureArray($filters['gender']);
            if (!empty($genders)) {
                $employees = $employees->whereIn('gender', $genders);
            }
        }

        // 8. CGPA filter (minimum CGPA)
        if ($request->filled('cgpa')) {
            $cgpa = (float)$request->input('cgpa');
            $employees = $employees->whereHas('employeeEducations', function ($q) use ($cgpa) {
                $q->where('cgpa', '>=', $cgpa);
            });
        }

        // 9. Experience filter (minimum years of experience)
        if ($request->filled('experience')) {
            $experience = (int)$request->input('experience');
            $employees = $employees->whereHas('employeeWorkExperiences', function ($q) use ($experience) {
                // Assuming you have start_date and end_date or total_experience field
                // Option 1: If you have a calculated experience field
                $q->where('duration', '>=', $experience);

                // Option 2: If you need to calculate from dates
                // $q->whereRaw('TIMESTAMPDIFF(MONTH, start_date, COALESCE(end_date, NOW())) >= ?', [$experience * 12]);
            });
        }

        // 10. Search Text filter (searches across multiple fields)
        if ($request->filled('search_text')) {
            $searchText = $request->input('search_text');
            $employees = $employees->where(function ($q) use ($searchText) {
                $q->where('name', 'LIKE', "%{$searchText}%")
                    ->orWhere('profile_title', 'LIKE', "%{$searchText}%")
                    ->orWhere('address', 'LIKE', "%{$searchText}%")
                    ->orWhere('email', 'LIKE', "%{$searchText}%")
//                    ->orWhere('bio', 'LIKE', "%{$searchText}%")
                    ->orWhereHas('universityName', function ($q) use ($searchText) {
                        $q->where('name', 'LIKE', "%{$searchText}%");
                    })
                    ->orWhereHas('industry', function ($q) use ($searchText) {
                        $q->where('name', 'LIKE', "%{$searchText}%");
                    })
                    ->orWhereHas('fieldOfStudy', function ($q) use ($searchText) {
                        $q->where('field_name', 'LIKE', "%{$searchText}%");
                    })
                    ->orWhereHas('employeeSkills', function ($q) use ($searchText) {
                        $q->where('skill_name', 'LIKE', "%{$searchText}%");
                    });
            });
        }

        // Execute query with pagination
        $employees = $employees->select([
            'id',
            'name',
            'profile_title',
            'address',
            'profile_image',
            'email',
            'gender',
            'district'
        ])->paginate(21);

        if (str()->contains(url()->current(), '/api/'))
        {
            $data = [
                'employees' => $employees,

                // Pass current filters back to the view for maintaining state
                'currentFilters' => [
                    'filters' => $filters,
                    'cgpa' => $request->input('cgpa'),
                    'experience' => $request->input('experience'),
                    'search_text' => $request->input('search_text'),
                ]
            ];
        } else {
            $data = [
                'employees' => $employees,
                'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name', 'slug']),
                'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name', 'slug']),
                'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
                'jobLocations' => JobLocationType::where(['status' => 1])->get(['id', 'name', 'slug']),
                'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name', 'slug']),
                'skillCategories' => SkillsCategory::where(['status' => 1])->with('skills')->get(['id', 'category_name', 'slug']),
                // Pass current filters back to the view for maintaining state
                'currentFilters' => [
                    'filters' => $filters,
                    'cgpa' => $request->input('cgpa'),
                    'experience' => $request->input('experience'),
                    'search_text' => $request->input('search_text'),
                ]
            ];
        }



        return ViewHelper::checkViewForApi($data, 'frontend.employer.jobs.head-hunt');
        return \view('frontend.employer.jobs.head-hunt');
    }

    public function getHeadHuntFilterOptions()
    {
        return response()->json([
            'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name', 'slug']),
            'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
            'jobLocations' => JobLocationType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name', 'slug']),
            'skillCategories' => SkillsCategory::where(['status' => 1])->with('skills')->get(['id', 'category_name', 'slug']),
        ]);
    }


    public function employeeProfile($userId)
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser) {
            if ($loggedUser->user_type == 'employer') {
                $existProfileView = UserProfileView::where(['employee_id' => $userId, 'employer_id' => $loggedUser->id, 'viewed_by' => 'employer'])->first();
                if (!$existProfileView) {
                    $newProfileView = new UserProfileView();
                    $newProfileView->employee_id = $userId;
                    $newProfileView->employer_id = $loggedUser->id;
                    $newProfileView->viewed_by = 'employer';
                    $newProfileView->employer_company_id = $loggedUser?->employerCompany?->id;
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
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax(['employeeDetails' => $employee], 'frontend.employer.profile.employer-profile');
        return view('frontend.employer.profile.employer-profile');
    }

    public function employerUserManagement()
    {
        $user = ViewHelper::loggedUser();
        $this->data = [
            'loggedUser' => $user,
            'employerUsers' => User::where(['user_type' => 'sub_employer', 'user_id' => $user->id])->get(['id', 'name', 'email', 'mobile', 'profile_image', 'user_type', 'employer_agent_active_status']),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.users');
        return view('frontend.employer.config.users');
    }

    public function employerUserInfo(User $user)
    {
        if (\request()->ajax()) {
            return \view('frontend.employer.include-edit-forms.employer-user', ['user' => $user])->render();
        }
        return \view('frontend.employer.include-edit-forms.employer-user', ['user' => $user]);
    }

    public function settings()
    {
        $this->data = [
            'loggedUser' => ViewHelper::loggedUser(),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.settings');
        return view('frontend.employer.config.settings');
    }

    public function companyProfile(Request $request)
    {
        $employerView = (isset($request->view) && $request->view == 'employer') ? false : true;
        $loggedUser = ViewHelper::loggedUser();
        if (isset($request->company_id) && isset($request->view)) {
            $companyDetails = EmployerCompany::find($request->company_id);
            $jobTasks = JobTask::with(['jobType', 'jobLocationType', 'employeeAppliedJobs'])
                ->where(['user_id' => $companyDetails?->ownerUserInfo?->id, 'status' => 1])
                ->where('is_softly_deleted', 0)
                ->get()
                ->map(function ($job) {
                    $job->type = 'job';
                    $job->display_title = $job->job_title; // For unified access
                    return $job;
                });

            $posts = Post::where(['user_id' => $companyDetails?->ownerUserInfo?->id, 'status' => 1])
                ->get()
                ->map(function ($post) {
                    $post->type = 'post';
                    $post->display_title = $post->title; // For unified access
                    return $post;
                });

// Merge and sort
            $merged = $jobTasks->concat($posts)->sortByDesc('created_at')->values();

// Manual pagination
            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $items = $merged->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $merged->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            $companyDetails = EmployerCompany::where(['user_id' => ViewHelper::loggedUser()->id])->first();
            $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]),
                0,
                10,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }
        $this->data = [
            'paginatedData' => $paginatedData,
            'employerView' => $employerView,
            'loggedUser' => $loggedUser,
            'companyDetails' => $companyDetails,
            'industries' => Industry::where(['status' => 1])->get(['id', 'name']),
            'employerCompanyCategories' => EmployerCompanyCategory::where(['status' => 1])->get(['id', 'category_name']),
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

    public function changeEmployeeJobApplicationStatus(Request $request, JobTask $jobTask, User $user, $status = 'pending')
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


            $webNotification = new WebNotification();
            $webNotification->viewer_id = $loggedUser->id;
            $webNotification->viewed_user_id = $user->id;
            $webNotification->notification_type = 'accept_application';
            $webNotification->msg = "$loggedUser->name has updated your job: $jobTask->job_title status to $status.";
            $webNotification->save();

            if (isset($user->email))
            {
                $msg = '';
                if ($status == 'shortlisted')
                    $msg = "Dear $user->name, Congratulations! We're pleased to inform you that your application for $jobTask->job_title has been shortlisted.";
                elseif ($status == 'pending')
                    $msg = "Dear $user->name, Thank you for applying to $jobTask->job_title at LikewiseBD. We have successfully received your application and it is currently under review.";
                elseif ($status == 'approved')
                    $msg = "Dear $user->name, We are delighted to inform you that you have been selected for job $jobTask->job_title at LikewiseBD!";
                elseif ($status == 'rejected')
                    $msg = "Dear $user->name, Thank you for your interest in the $jobTask->job_title position at LikewiseBD and for taking the time to apply.
After careful consideration, we regret to inform you that we have decided to move forward with other candidates whose qualifications more closely match our current needs.";
                $data = [
                    'user'   => $user,
                    'request'   => $request,
                    'msg'   => $msg,
                    'status'   => $status,
                    'siteSetting'   => SiteSetting::first(),
                ];
                Mail::send('frontend.employer.jobs.job-status-change-mail', $data, function ($message) use ($data, $user, $status){
                    $message->to($user->email, 'Like Wise Bd')->subject("Job Status Changed to $status");
                });
            }


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
            $user->profile_image = imageUpload($request->file('profile_image'), 'profile_images', 'profile_images', 150, 100, $user->profile_image);
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
            $company->founded_on = /*date('Y-m-d', strtotime($request->founded_on)) ?? null*/
                $request->founded_on ?? $company->founded_on;
            $company->total_employees = (int)$request->total_employees ?? ($company->total_employees ?? 0);
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
            $user->is_profile_updated = $request->is_profile_updated ?? $user->is_profile_updated;
            $user->save();
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
            'email' => ['email', 'unique:users,email'],
            'mobile' => ['required', 'regex:/^01[3-9]\d{8}$/', 'unique:users,mobile'],
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
            $subUser->roles()->sync(5);
            return ViewHelper::returnSuccessMessage('Sub Employer created successfully');
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());
        }
    }

    public function updateSubUser(User $user, Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Name is required.',
            'email.email' => 'Please provide a valid email address with a valid domain.',
            'email.unique' => 'This email is already registered.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.unique' => 'This mobile number is already registered.',
            'mobile.regex' => 'Please provide a valid Bangladeshi mobile number (11 digits starting with 01).',
        ];

// Only validate email if it's different
        if ($request->email != $user->email) {
            $rules['email'] = ['required', 'email:rfc,dns', 'unique:users'];
        }

// Only validate mobile if it's different
        if ($request->mobile != $user->mobile) {
            $rules['mobile'] = ['required', 'regex:/^01[3-9]\d{8}$/', 'unique:users'];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ViewHelper::returEexceptionError($validator->errors());
        }

        if (User::where(['user_id' => $user->id, 'user_type' => 'sub_employer'])->count() >= 5) {
            return ViewHelper::returEexceptionError('You can not create more than 5 sub users');
        }

        try {
//            $subUser = new User();
            $user->name = $request->name;
            if ($request->email != $user->email)
                $user->email = $request->email;
            if ($request->mobile != $user->mobile)
                $user->mobile = $request->mobile;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->user_type = 'sub_employer';
            $user->user_id = $loggedUser->id;
//            $user->employer_company_id = $user->employer_company_id;
//            $user->organization_name = $user->organization_name;
            $user->employer_agent_active_status = $request->employer_agent_active_status;
            $user->save();
            Toastr::success('Sub user updated successfully');
            return redirect()->route('employer.employer-user-management');
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
            'loggedUser' => ViewHelper::loggedUser(),
            'subscriptionPlans' => SubscriptionPlan::where(['status' => 1, 'subscription_for' => 'employer'])->active()->get()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employer.config.my-subscriptions');
        return \view('frontend.employer.config.my-subscriptions');
    }

    public function myNotifications()
    {
        $loggedUser = ViewHelper::loggedUser();
        $webNotifications = WebNotification::where(['status' => 1])->where('viewed_user_id', $loggedUser->id)->paginate(20);
        $newNotifications = $webNotifications->where('is_seen', 0)->count();
        $data = [
            'notifications' => $webNotifications,
            'newNotifications' => $newNotifications,

        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.my-notifications');
        return \view('frontend.employee.base-functionalities.my-notifications');
    }

    public function employeeSuggestions()
    {
        $employees = User::where(['user_type' => 'employee'])->latest()->select(['id', 'name', 'profile_title', 'address', 'profile_image'])->paginate(20);
        $data = [
            'employees' => $employees,
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employer.home.suggested-employees');
        return \view('frontend.employer.home.suggested-employees');
    }
}
