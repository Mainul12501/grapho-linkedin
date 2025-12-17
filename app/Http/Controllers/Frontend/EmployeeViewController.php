<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\FirebaseHelper;
use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Crud\JobTaskController;
use App\Models\Backend\EducationDegreeName;
use App\Models\Backend\EmployeeAppliedJob;
use App\Models\Backend\EmployeeDocument;
use App\Models\Backend\EmployeeEducation;
use App\Models\Backend\EmployeeWorkExperience;
use App\Models\Backend\EmployerCompany;
use App\Models\Backend\EmployerCompanyCategory;
use App\Models\Backend\FieldOfStudy;
use App\Models\Backend\Industry;
use App\Models\Backend\JobLocationType;
use App\Models\Backend\JobTask;
use App\Models\Backend\JobType;
use App\Models\Backend\Post;
use App\Models\Backend\SubscriptionPlan;
use App\Models\Backend\UniversityName;
use App\Models\Backend\UserProfileView;
use App\Models\Backend\WebNotification;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use PHPUnit\Util\PHP\Job;

class EmployeeViewController extends Controller
{
    protected $data = [];

    public function employeeHome()
    {
//        $topJobsForEmployee = JobTask::where(['status' => 1])->with('employerCompany', 'jobType')->take(5)->latest()->get();
//        $loggedUser = ViewHelper::loggedUser();
//        $userSavedJobs = $loggedUser->employeeSavedJobs;
//        $userAppliedJobs = $loggedUser->employeeAppliedJobs;

        $loggedUser = ViewHelper::loggedUser();


        if (ViewHelper::checkIfRequestFromApi())
        {
            $topJobsForEmployee = JobTask::where(['status' => 1])
                ->with('employerCompany', 'jobType', 'jobLocationType')
                ->where('is_softly_deleted', 0)
                ->latest()
                ->take(5)
                ->get();

            $moreJobsForEmployee = JobTask::where(['status' => 1])
                ->with('employerCompany', 'jobType', 'jobLocationType')
                ->where('is_softly_deleted', 0)
                ->inRandomOrder()
                ->take(5)
                ->get();
        } else {
            $topJobsForEmployee = JobTask::where(['status' => 1])
                ->whereDoesntHave('employeeAppliedJobs', function($query) use ($loggedUser) {
                    $query->where('employee_applied_jobs.user_id', $loggedUser->id);
                })
                ->whereDoesntHave('employeeSavedJobs', function($query) use ($loggedUser) {
                    $query->where('job_task_user.user_id', $loggedUser->id);
                })
                ->with('employerCompany', 'jobType', 'jobLocationType')
                ->where('is_softly_deleted', 0)
                ->latest()
                ->take(5)
                ->get();

            $moreJobsForEmployee = JobTask::where(['status' => 1])
                ->whereDoesntHave('employeeAppliedJobs', function($query) use ($loggedUser) {
                    $query->where('employee_applied_jobs.user_id', $loggedUser->id);
                })
                ->whereDoesntHave('employeeSavedJobs', function($query) use ($loggedUser) {
                    $query->where('job_task_user.user_id', $loggedUser->id);
                })
                ->with('employerCompany', 'jobType', 'jobLocationType')
                ->where('is_softly_deleted', 0)
                ->inRandomOrder()
                ->take(5)
                ->get();
        }

        $allJobs = $topJobsForEmployee->merge($moreJobsForEmployee);
        foreach ($allJobs as $job)
        {
            $job->isSaved = ViewHelper::getJobSaveApplyInfo($job->id)['isSaved'] ?? false;
            $job->isApplied = ViewHelper::getJobSaveApplyInfo($job->id)['isApplied'] ?? false;
        }

        $appliedJobIds = $loggedUser->appliedJobsWithJobDetails()
            ->pluck('job_task_id');

        $savedJobs = $loggedUser->employeeSavedJobs()->whereNotIn('job_tasks.id', $appliedJobIds)->count();

        $data = [
            'totalSavedJobs' => $savedJobs ?? 0,
            'totalAppliedApplications' => ViewHelper::loggedUser()->employeeAppliedJobs()->count() ?? 0,
            'totalViewedEmployers' => ViewHelper::loggedUser()->viewedEmployers()->count() ?? 0,
            'topJobsForEmployee' => $topJobsForEmployee,
            'moreJobsForEmployee' => $moreJobsForEmployee,
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.home.home');
        return \view('frontend.employee.home.home');
    }

    public function getTotalSavedJobs(Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        $appliedJobIds = $loggedUser->appliedJobsWithJobDetails()
            ->pluck('job_task_id');

        $savedJobs = $loggedUser->employeeSavedJobs()->whereNotIn('job_tasks.id', $appliedJobIds)->count();
        return response()->json($savedJobs ?? 0);
    }

    public function viewCompanyProfile(EmployerCompany $employerCompany, Request $request)
    {
        $jobTasks = JobTask::with(['jobType', 'jobLocationType', 'employeeAppliedJobs'])
            ->where(['user_id' => $employerCompany?->ownerUserInfo?->id, 'status' => 1])
            ->where('is_softly_deleted', 0)
            ->get()
            ->map(function ($job) {
                $job->type = 'job';
                $job->display_title = $job->job_title; // For unified access
                return $job;
            });

        $posts = Post::where(['user_id' => $employerCompany?->ownerUserInfo?->id, 'status' => 1])
            ->get()
            ->map(function ($post) {
                $post->type = 'post';
                $post->display_title = $post->title; // For unified access
                return $post;
            });

// Merge and sort
        $merged = $jobTasks->concat($posts)->sortByDesc('created_at')->values();

        if (count($merged) > 0)
        {
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
            $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]),
                0,
                10,
                1,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }


        $data = [
            'employerCompany' => $employerCompany,
            'paginatedData' => $paginatedData
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.company-profile');
        return \view('frontend.employee.jobs.company-profile');
    }

    public function showJobs(Request $request)
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(auth()->user()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employee.home', 'error', 'Your account is blocked or has not approved yet. Please contact with admin.'));
        }
        $jobTasks = JobTask::query()->with(['employerCompany.employerCompanyCategory', 'jobLocationType', 'industry', 'jobType']);

        // Get filters array
        $filters = $request->input('filters', []);

        // Search by text (job title, company name, or industry name)
        if ($request->has('search_text') && !empty($request->search_text)) {
            $searchText = $request->search_text;

            $jobTasks = $jobTasks->where(function ($query) use ($searchText) {
                $query->where('job_title', 'like', '%' . $searchText . '%')
                    ->orWhereHas('employerCompany', function ($q) use ($searchText) {
                        $q->where('name', 'like', '%' . $searchText . '%');
                    })
                    ->orWhereHas('industry', function ($q) use ($searchText) {
                        $q->where('name', 'like', '%' . $searchText . '%');
                    });
            });
        }

        // Filter by Date Posted (new filter)
        if (isset($filters['date_posted']) && !empty($filters['date_posted'])) {
            $datePostedFilter = json_decode($filters['date_posted'], true);

            if (is_array($datePostedFilter) && !empty($datePostedFilter)) {
                // Get the minimum days from the selected options (most restrictive)
                $minDays = min(array_map('intval', $datePostedFilter));

                $jobTasks = $jobTasks->where('created_at', '>=', now()->subDays($minDays));
            }
        }

        // Filter by Company Type (via EmployerCompanyCategory slug)
        if (isset($filters['company_type']) && !empty($filters['company_type'])) {
            $companyTypes = json_decode($filters['company_type'], true);

            if (is_array($companyTypes) && !empty($companyTypes)) {
                $jobTasks = $jobTasks->whereHas('employerCompany.employerCompanyCategory', function ($q) use ($companyTypes) {
                    $q->whereIn('slug', $companyTypes);
                });
            }
        }

        // Filter by District (search in employer company address)
        if (isset($filters['district']) && !empty($filters['district'])) {
            $districts = json_decode($filters['district'], true);

            if (is_array($districts) && !empty($districts)) {
                $jobTasks = $jobTasks->whereHas('employerCompany', function ($q) use ($districts) {
                    $q->where(function ($query) use ($districts) {
                        foreach ($districts as $district) {
                            $query->orWhere('address', 'like', '%' . $district . '%');
                        }
                    });
                });
            }
        }

        // Filter by Job Location Type
        if (isset($filters['job_location_type']) && !empty($filters['job_location_type'])) {
            $jobLocationTypes = json_decode($filters['job_location_type'], true);

            if (is_array($jobLocationTypes) && !empty($jobLocationTypes)) {
                $jobTasks = $jobTasks->whereHas('jobLocationType', function ($q) use ($jobLocationTypes) {
                    $q->whereIn('slug', $jobLocationTypes);
                });
            }
        }

        // filter by job types
        if (isset($filters['job_type']) && !empty($filters['job_type'])) {
            $jobTypes = json_decode($filters['job_type'], true);

            if (is_array($jobTypes) && !empty($jobTypes)) {
                $jobTasks = $jobTasks->whereHas('jobType', function ($j) use ($jobTypes) {
                    $j->whereIn('slug', $jobTypes);
                });
            }
        }

        // Filter by Industry
        if (isset($filters['industry']) && !empty($filters['industry'])) {
            $industries = json_decode($filters['industry'], true);

            if (is_array($industries) && !empty($industries)) {
                $jobTasks = $jobTasks->whereHas('industry', function ($q) use ($industries) {
                    $q->whereIn('slug', $industries);
                });
            }
        }

        // Filter by Company
        if (isset($filters['company']) && !empty($filters['company'])) {
            $companies = json_decode($filters['company'], true);

            if (is_array($companies) && !empty($companies)) {
                $jobTasks = $jobTasks->whereHas('employerCompany', function ($q) use ($companies) {
                    $q->whereIn('slug', $companies);
                });
            }
        }

        $jobTasks = $jobTasks->where(['status' => 1])->where('is_softly_deleted', 0)->latest()->paginate(15);


        // Handle AJAX request for infinite scroll
        if ($request->ajax()) {
            $html = view('frontend.employee.jobs.partials.job-list', [
                'jobTasks' => $jobTasks,
                'singleJobTask' => $jobTasks->first()
            ])->render();

            return response()->json([
                'html' => $html,
                'next_page' => $jobTasks->currentPage() + 1,
                'has_more' => $jobTasks->hasMorePages()
            ]);
        }

        if (count($jobTasks) > 0) {
            foreach ($jobTasks as $jobTask) {
                $jobTask->isSaved = $getJobSaveApplyInfo['isSaved'] ?? false;
                $jobTask->isApplied = $getJobSaveApplyInfo['isApplied'] ?? false;
            }
        }

        if (isset($request->job_task)) {
            $singleJobTask = JobTask::find($request->job_task);
        } else {
            $singleJobTask = $jobTasks->first() ?? null;
        }

        $getJobSaveApplyInfo = null;
        if ($singleJobTask) {
            $getJobSaveApplyInfo = ViewHelper::getJobSaveApplyInfo($singleJobTask->id);
        }
        $foundData = true;
        if (count($jobTasks) == 0)
            $foundData = false;
        $data = [
            'foundData' => $foundData,
            'jobTasks' => $jobTasks,
            'singleJobTask' => $singleJobTask,
            'isSaved' => $getJobSaveApplyInfo['isSaved'] ?? false,
            'isApplied' => $getJobSaveApplyInfo['isApplied'] ?? false,
            'jobLocationTypes' => JobLocationType::where(['status' => 1])->get(['id', 'name', 'slug']),
            'industries' => Industry::where(['status' => 1])->get(['id', 'name', 'slug']),
            'companies' => EmployerCompany::where(['status' => 1])->get(['id', 'name', 'slug']),
            'JobTypes' => JobType::where(['status' => 1])->get(['id', 'name', 'slug']),
        ];

        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.show-jobs');
        return \view('frontend.employee.jobs.show-jobs', $data);
    }

    public function mySavedJobs()
    {
        $loggedUser = ViewHelper::loggedUser();

        $appliedJobIds = $loggedUser->appliedJobsWithJobDetails()
            ->pluck('job_task_id');
        if (ViewHelper::checkIfRequestFromApi())
        {
            $savedJobs = $loggedUser->employeeSavedJobs()->get();
        } else {
            $savedJobs = $loggedUser->employeeSavedJobs()->whereNotIn('job_tasks.id', $appliedJobIds)->get();
        }

        foreach ($savedJobs as $savedJob) {
            $savedJob->isApplied = ViewHelper::getJobSaveApplyInfo($savedJob->id);
        }
        $data = $loggedUser ? [
            'savedJobs' => $savedJobs ?? [],
        ] : [];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.my-saved-jobs');
        return \view('frontend.employee.jobs.my-saved-jobs');
    }

    public function myApplications(Request $request)
    {
        $user = ViewHelper::loggedUser();
//        return $user->employeeAppliedJobs;
        $myApplications = $user->appliedJobsWithJobDetails()
            ->latest()
            ->paginate(10);
        if ($request->ajax()) {
            return view(
                'frontend.employee.jobs.partials.my-applications-items',
                compact('myApplications')
            )->render();
        }
        $data = [
//            'myApplications'    => $user->employeeAppliedJobs
//            'myApplications'    => $user->appliedJobs
            'myApplications' => $myApplications
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.jobs.my-applications');
        return \view('frontend.employee.jobs.my-applications');
    }

    public function myProfileViewers(Request $request)
    {
        $user = ViewHelper::loggedUser();
        $profileViewerIds = UserProfileView::where(['employee_id' => $user->id, 'viewed_by' => 'employer'])->with('employer.employerCompanyInfo')->paginate(10);
        // 👇 When scrolling (AJAX request)
        if ($request->ajax()) {
            return view(
                'frontend.employee.base-functionalities.partials.profile-viewer-items',
                compact('profileViewerIds')
            )->render();
        }
        $data = [
            'myProfileViewers' => $profileViewerIds
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.profile-viewers');
        return \view('frontend.employee.base-functionalities.profile-viewers');
    }

    public function mySubscriptions()
    {
        $this->data = [
            'loggedUser' => ViewHelper::loggedUser(),
            'subscriptionPlans' => SubscriptionPlan::where(['status' => 1, 'subscription_for' => 'employee'])->active()->get()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employee.base-functionalities.my-subscriptions');
        return \view('frontend.employee.base-functionalities.my-subscriptions');
    }

    public function settings()
    {
        $this->data = [
            'loggedUser' => ViewHelper::loggedUser()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.employee.base-functionalities.settings');
        return \view('frontend.employee.base-functionalities.settings');
    }

    public function myProfile()
    {
        $loggedUser = ViewHelper::loggedUser();
        if (str()->contains(url()->current(), '/api/')) {
            $loggedUser->profile_image = asset($loggedUser->profile_image);
        }
        $totalSavedJobs = $loggedUser->employeeSavedJobs->whereNotIn('id', $loggedUser->employeeAppliedJobs->pluck('id'))->count();

        $data = [
            'workExperiences' => EmployeeWorkExperience::where(['user_id' => auth()->id(), 'status' => 1])->get(), // stringp tags for api
            'employeeEducations' => EmployeeEducation::where(['user_id' => auth()->id(), 'status' => 1])->get(),
            'employeeDocuments' => EmployeeDocument::where(['user_id' => auth()->id(), 'status' => 1])->get(),
            'employeeProfileDate' => $loggedUser,
            'educationDegreeNames' => EducationDegreeName::where(['status' => 1])->get(['id', 'degree_name', 'need_institute_field']),
            'universityNames' => UniversityName::where(['status' => 1])->get(['id', 'name']),
            'fieldOfStudies' => FieldOfStudy::where(['status' => 1])->get(['id', 'field_name']),
            'companyList' => EmployerCompany::where(['status' => 1])->get(['id', 'name']),
            'jobTypes' => JobType::where(['status' => 1])->get(['id', 'name']),
            'totalSavedJobs'    => $totalSavedJobs,
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.my-profile');
        return \view('frontend.employee.base-functionalities.my-profile');
    }

    public function myNotifications(Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        $webNotifications = WebNotification::where(['status' => 1])->where('viewed_user_id', $loggedUser->id)->paginate(10);
        $newNotifications = $webNotifications->where('is_seen', 0)->count();
        // 👇 When loading more via scroll
        if ($request->ajax()) {
            return view(
                'frontend.employee.base-functionalities.partials.notification-items',
                compact('webNotifications')
            )->render();
        }
        $data = [
            'notifications' => $webNotifications,
            'newNotifications' => $newNotifications,

        ];
        return ViewHelper::checkViewForApi($data, 'frontend.employee.base-functionalities.my-notifications');
        return \view('frontend.employee.base-functionalities.my-notifications');
    }

    public function saveJob(Request $request, JobTask $jobTask)
    {
        if (ViewHelper::checkIfUserApprovedOrBlocked(ViewHelper::loggedUser()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employee.home', 'error', 'Your account is blocked or has not approved yet. Please contact with admin.'));
        }
        $user = ViewHelper::loggedUser();
        if (isset($jobTask) && $user) {
            $user->employeeSavedJobs()->syncWithoutDetaching($jobTask->id);
            $data = [
                'status' => 'success',
                'msg' => 'Job Saved successfully.'
            ];
        } else {
            $data = [
                'status' => 'error',
                'msg' => 'Job or User Not found.'
            ];
        }

        return ViewHelper::returnBackViewAndSendDataForApiAndAjax($data);
    }

    public function deleteSaveJob(Request $request, JobTask $jobTask)
    {
        if ($jobTask) {
            $user = ViewHelper::loggedUser();
            $user->employeeSavedJobs()->detach($jobTask->id);
            return ViewHelper::returnSuccessMessage('Job removed from my jobs.');
        } else {
            return ViewHelper::returEexceptionError('Job not found');
        }
    }

    public function changeJobActiveStatus($status = 0)
    {
        $loggedUser = ViewHelper::loggedUser();
        $loggedUser->is_open_for_hire = $status;
        $loggedUser->save();
        return ViewHelper::returnSuccessMessage('Your job active status changed successfully.');
    }

    public function applyJob(Request $request, JobTask $jobTask)
    {
        if ($jobTask->is_softly_deleted == 1)
        {
            return ViewHelper::returEexceptionError('Job is blocked by Likewise. Please contact with Likewise.');
        }
        if (ViewHelper::checkIfUserApprovedOrBlocked(ViewHelper::loggedUser()))
        {
            return ViewHelper::returnRedirectWithMessage(route('employee.home', 'error', 'Your account is blocked or has not approved yet. Please contact with admin.'));
        }
//        return $jobTask;
        $loggedUser = ViewHelper::loggedUser();
        if ($jobTask && $loggedUser) {
            try {
                $employeeAppliedJob = new EmployeeAppliedJob();
                $employeeAppliedJob->user_id = $loggedUser->id;
                $employeeAppliedJob->job_task_id = $jobTask->id;
                $employeeAppliedJob->status = 'pending';
                $employeeAppliedJob->save();

                $webNotification = new WebNotification();
                $webNotification->viewer_id = $jobTask->id;
                $webNotification->viewed_user_id = $loggedUser->id;
                $webNotification->notification_type = 'accept_application';
                $webNotification->msg = "$loggedUser->name has applied to your job: $jobTask->job_title.";
                $webNotification->save();

                // send notification to firebase
                FirebaseHelper::sendJobApplicationNotification($jobTask->user_id, $loggedUser->name ?? 'employee', $loggedUser->id, $jobTask->job_title, $jobTask->id );

                return ViewHelper::returnSuccessMessage('You applied for this job successfully.');
            } catch (\Exception $exception) {
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
        $validator = Validator::make($request->all(), [
            'email' => [
                'nullable',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($user->id),
//                $user->email != $request->email ? 'unique:users,email' : ''
            ],
//            'mobile' => $user->mobile != $request->mobile ? ['unique:users,mobile', 'regex:/^01[0-9]{9}$/'] : '',
            'mobile' => [
                'regex:/^01[0-9]{9}$/',
                Rule::unique('users', 'mobile')->ignore($user->id)
            ],
        ], [
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email address is already taken',
            'mobile.unique' => 'This mobile number is already registered',
            'mobile.regex' => 'Mobile number must be 11 digits and start with 01',
        ]);
        if ($validator->fails()) {
//            Toastr::error($validator->errors());
            return ViewHelper::returEexceptionError($validator->errors());
            return back();
        }
        if (isset($request->prev_password) && isset($request->new_password)) {
            if (!Hash::check($request->prev_password, $user->password)) {
                return ViewHelper::returEexceptionError('Password Mismatch. Please provide correct password.');
            }
        }
        try {

            if ($user) {
                $user->profile_title = $request->profile_title ?? $user->profile_title;
                $user->name = $request->name ?? $user->name;
                $user->email = $request->email ?? $user->email;
                $user->mobile = $request->mobile ?? $user->mobile;
                $user->website = $request->website ?? $user->website;
                $user->division = $request->division ?? $user->division;
                $user->district = $request->district ?? $user->district;
                $user->post_office = $request->post_office ?? $user->post_office;
                $user->postal_code = $request->postal_code ?? $user->postal_code;
                $user->is_open_for_hire = $request->is_open_for_hire ?? $user->is_open_for_hire;
                $user->is_profile_updated = $request->is_profile_updated ?? $user->is_profile_updated;
                if (isset($request->cropped_image_data)) {
                    $user->profile_image = imageUpload($request->cropped_image_data, 'profile-image', 'profile_image', 200, 200, $user->profile_image ?? null, true);
                } elseif ($request->hasFile('profile_image')) {
                    $user->profile_image = imageUpload($request->file('profile_image'), 'profile-image', 'profile_image', 200, 200, $user->profile_image ?? null);
                }
                $user->address = $request->address ?? $user->address;
                $user->save();
            }
//            Toastr::success('Profile Info updated successfully.');
            return ViewHelper::returnResponseFromPostRequest(true, 'Profile Info updated successfully.');
        } catch (\Exception $exception) {
//            Toastr::error($exception->getMessage());
            return ViewHelper::returnResponseFromPostRequest(false, $exception->getMessage());
        }
        return back();
    }

    public function updateEmployeeInfo(Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser) {
            $loggedUser->jobTypes()->syncWithoutDetaching($request->job_type_id);
            $loggedUser->jobLocationTypes()->syncWithoutDetaching($request->job_location_type_id);
            if ($request->has('cropped_image_data')) {
                if ($loggedUser->user_type == 'employee') {
                    $loggedUser->profile_image = imageUpload($request->cropped_image_data, 'profile-image', 'profile_image', 200, 200, $user->profile_image ?? null, true);
                } else {
                    $company = EmployerCompany::find($loggedUser->employerCompany->id);
                    $loggedUser->profile_image = imageUpload($request->cropped_image_data, 'profile-image', 'profile_image', 200, 200, $user->profile_image ?? null, true);
                    $company->logo = $loggedUser->profile_image = imageUpload($request->cropped_image_data, 'employer_company_logos', 'employer_company_logos', 200, 200, $user->profile_image ?? null, true);
                    $company->save();
                }
                $loggedUser->save();
            }
            return ViewHelper::returnSuccessMessage('Data Updated successfully.');
        } else {
            return ViewHelper::returEexceptionError('Employee Not Found');
        }
    }

    public function makeMsgSeen($webNotificationId)
    {
        try {
            $webNotification = WebNotification::find($webNotificationId);
            $webNotification->is_seen   = 1;
            $webNotification->save();
            return response()->json([
                'status'    => 'success',
                'msg'   => 'Notification checked.',
            ]);
        } catch (\Exception $exception)
        {
            return response()->json([
                'status'    => 'error',
                'msg'   => 'something went wrong. Please try again.',
            ]);
        }
    }

    public function employeeViewPost(Post $post, Request $request)
    {
        $post = Post::with(['employer' => function ($employer) {
            $employer->select('id', 'name', 'employer_company_id')->with(['employerCompany' => function ($employerCompany) {
                $employerCompany->select('id', 'user_id', 'logo');
            }]);
        }])->find($post->id);
        $data = [
            'post'  => $post,
        ];
        if (\request()->ajax() && isset($_GET['req_from']) && $_GET['req_from'] == 'admin')
        {
            return view('backend.user-management.view-post', $data)->render();
        }
        return ViewHelper::checkViewForApi($data, 'frontend.employee.home.view-post');
        return view('frontend.employee.home.view-post');
    }
}
