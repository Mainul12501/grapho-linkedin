<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\FrontendViewController;
use App\Http\Controllers\Frontend\EmployerViewController;
use App\Http\Controllers\Frontend\EmployeeViewController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\Crud\EmployeeWorkExperienceController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Frontend\Crud\JobTaskController;
use App\Http\Controllers\Frontend\Crud\EmployeeEducationController;
use App\Http\Controllers\Frontend\Crud\EmployeeDocumentsController;
use App\Http\Controllers\Frontend\Twilio\TwilioVideoController;
use App\Http\Controllers\Frontend\Crud\PostController;
use App\Http\Controllers\Frontend\Crud\FollowerHistroyController;
use App\Http\Controllers\Api\Mobile\ZegoCloudMobileController;
use App\Http\Controllers\Api\ZegoCloudApiController;
use App\Http\Controllers\Frontend\ZegoCloud\ZegoCloudController;
use App\Http\Controllers\Frontend\ZegoCloud\ZegoGroupCallController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/page/{slug?}', [FrontendViewController::class, 'showCommonPage']);
Route::get('/check-block-approve-status', [FrontendViewController::class, 'checkBlockApproveStatus']);
Route::post('send-otp', [CustomLoginController::class, 'sendOtp'])->name('send-otp');
Route::post('verify-otp', [CustomLoginController::class, 'verifyOtp']);
Route::post('login-with-google-app', [CustomLoginController::class, 'loginWithGoogleApp']);
Route::post('buy-subscription/{subscriptionPlan}', [FrontendViewController::class, 'buySubscription']);

Route::get('search-skills', [JobTaskController::class, 'searchSkills']);

Route::get('employee-profile/{employeeId}', [EmployerViewController::class, 'employeeProfile']);
Route::get('get-job-details/{id}', [JobTaskController::class, 'getJobDetails']);
Route::get('get-site-settings', [FrontendViewController::class, 'getSiteSetting']);

Route::post('/call/initiate', [ZegoCloudController::class, 'initiateCall']);

Route::prefix('auth')->name('auth.')->group(function (){
    Route::get('select-auth-method', [CustomLoginController::class, 'selectAuthMethod']);
    Route::get('set-registration-role', [CustomLoginController::class, 'setRegistrationRole']);
    Route::get('set-login-role', [CustomLoginController::class, 'setLoginRole']);
    Route::get('user-login-page', [CustomLoginController::class, 'userLoginPage']);
    Route::get('user-registration-page', [CustomLoginController::class, 'userRegistrationPage']);

    Route::post('custom-registration', [CustomLoginController::class, 'customRegistration']);
    Route::post('custom-login', [CustomLoginController::class, 'customLogin']);

    Route::get('forgot-password-page', [CustomLoginController::class, 'forgotPasswordPage']);
    Route::post('send-forgot-password-otp', [CustomLoginController::class, 'sendForgotPasswordOtp']);
    Route::post('verify-forgot-password-otp', [CustomLoginController::class, 'verifyForgotPasswordOtp']);
    Route::post('reset-password', [CustomLoginController::class, 'resetPassword']);
});

//twilio video page routes
Route::get('/view-twilio-video-page', [TwilioVideoController::class, 'viewPage']);
Route::post('/video/token', [TwilioVideoController::class, 'token']);
Route::post('/audio/token', [TwilioVideoController::class, 'audioToken']);
// Protected (host actions) -- twilio
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/twilio/invite', [TwilioVideoController::class, 'inviteCreate']);
    Route::post('/twilio/kick', [TwilioVideoController::class, 'kickParticipant']);
    Route::get('/twilio/logs', [TwilioVideoController::class, 'logs']);
    Route::post('/twilio/mark-started', [TwilioVideoController::class, 'markStarted']);
    Route::post('/twilio/complete', [TwilioVideoController::class, 'completeRoom']);
});

Route::middleware([
    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
])->group(function () {

    Route::get('switch-user-auth-guard', [CustomLoginController::class, 'switchUserAuthGuard']);

    Route::post('update-zego-caller-id', [CustomLoginController::class, 'updateZegoCallerId']);
    Route::post('update-fcm-token', [CustomLoginController::class, 'updateFcmToken']);
    Route::get('auth/user-profile-update', [CustomLoginController::class, 'userProfileUpdate']);
    Route::get('call-user/{type?}', [TwilioVideoController::class, 'viewPage']);
    Route::get('view-company-profile/{employerCompany}', [EmployeeViewController::class, 'viewCompanyProfile']);

    Route::post('auth/user-password-update', [CustomLoginController::class, 'userPasswordUpdate'])->name('auth.user-password-update');

    Route::prefix('employer')->as('employer.')->middleware('isEmployer')->group(function (){
        Route::get('home', [EmployerViewController::class, 'employerHome']);
        Route::get('dashboard', [EmployerViewController::class, 'dashboard']);
        Route::get('my-jobs', [EmployerViewController::class, 'myJobs']);
        Route::get('my-job-wise-applicants', [EmployerViewController::class, 'myJobWiseApplicants']);
        Route::get('my-job-applicants/{jobTask}', [EmployerViewController::class, 'myJobApplicants']);
        Route::get('head-hunt', [EmployerViewController::class, 'headHunt']);
        Route::get('get-head-hunt-filter-options', [EmployerViewController::class, 'getHeadHuntFilterOptions']);
        Route::get('employer-user-management', [EmployerViewController::class, 'employerUserManagement']);
        Route::get('settings', [EmployerViewController::class, 'settings']);
        Route::get('company-profile', [EmployerViewController::class, 'companyProfile']);
        Route::get('change-sub-employer-status/{user}/{status}', [EmployerViewController::class, 'changeSubEmployerStatus']);
        Route::get('change-employee-job-application-status/{jobTask}/{user}/{status?}', [EmployerViewController::class, 'changeEmployeeJobApplicationStatus']);
        Route::get('employer-subscriptions', [EmployerViewController::class, 'employerSubscriptions']);
        Route::get('view-post/{post}', [PostController::class, 'viewPost']);
        Route::get('set-follow-history', [FollowerHistroyController::class, 'store']);
        Route::get('close-job/{jobTask}/{status}', [JobTaskController::class, 'closeJob']);
        Route::get('my-notifications', [EmployerViewController::class, 'myNotifications']);

        Route::post('update-settings', [EmployerViewController::class, 'updateSettings']);
        Route::post('update-company-info', [EmployerViewController::class, 'updateCompanyInfo']);
        Route::post('create-sub-user', [EmployerViewController::class, 'createSubUser']);
        Route::post('delete-sub-employer/{user}', [EmployerViewController::class, 'deleteSubEmployer']);

        Route::resources([
            'job-tasks'  => JobTaskController::class,
            'posts'  => PostController::class
        ]);
    });
    Route::prefix('employee')->as('employee.')->middleware('isEmployee')->group(function (){
        Route::get('home', [EmployeeViewController::class, 'employeeHome']);
        Route::get('show-jobs', [EmployeeViewController::class, 'showJobs']);
        Route::get('my-saved-jobs', [EmployeeViewController::class, 'mySavedJobs']);
        Route::get('my-applications', [EmployeeViewController::class, 'myApplications']);
        Route::get('my-profile-viewers', [EmployeeViewController::class, 'myProfileViewers']);
        Route::get('my-subscriptions', [EmployeeViewController::class, 'mySubscriptions']);
        Route::get('settings', [EmployeeViewController::class, 'settings']);
        Route::get('my-profile', [EmployeeViewController::class, 'myProfile']);
        Route::get('my-notifications', [EmployeeViewController::class, 'myNotifications']);
        Route::get('save-job/{jobTask}', [EmployeeViewController::class, 'saveJob']);
        Route::get('delete-saved-job/{jobTask}', [EmployeeViewController::class, 'deleteSaveJob']);
        Route::get('change-job-active-status/{status}', [EmployeeViewController::class, 'changeJobActiveStatus']);
        Route::get('get-total-saved-jobs', [EmployeeViewController::class, 'getTotalSavedJobs']);

        Route::post('apply-job/{jobTask}', [EmployeeViewController::class, 'applyJob']);
        Route::post('update-profile/{user}', [EmployeeViewController::class, 'updateProfile']);
        Route::post('update-employee-info', [EmployeeViewController::class, 'updateEmployeeInfo']);

//        crud routes
        Route::resources([
            'employee-work-experiences' => EmployeeWorkExperienceController::class,
            'employee-educations' => EmployeeEducationController::class,
            'employee-documents'    => EmployeeDocumentsController::class,
        ]);
    });

    // Mobile App API Routes for ZegoCloud Calling
    Route::prefix('mobile/call')->name('mobile.call.')->group(function () {
        // Device registration
        Route::post('/register-device', [ZegoCloudMobileController::class, 'registerDevice']);
        Route::post('/update-online-status', [ZegoCloudMobileController::class, 'updateOnlineStatus']);

        // Call management
        Route::post('/initiate', [ZegoCloudMobileController::class, 'initiateCall']);
        Route::post('/{callId}/accept', [ZegoCloudMobileController::class, 'acceptCall']);
        Route::post('/{callId}/reject', [ZegoCloudMobileController::class, 'rejectCall']);
        Route::post('/{callId}/end', [ZegoCloudMobileController::class, 'endCall']);

        // Call information
        Route::get('/active-calls', [ZegoCloudMobileController::class, 'getActiveCalls']);
        Route::get('/call-history', [ZegoCloudMobileController::class, 'getCallHistory']);
        Route::get('/{callId}/details', [ZegoCloudMobileController::class, 'getCallDetails']);
        Route::get('/user/{userId}/availability', [ZegoCloudMobileController::class, 'checkUserAvailability']);

        // ZegoCloud configuration
        Route::post('/generate-token', [ZegoCloudMobileController::class, 'generateToken']);
    });

    // Mobile App API Routes for ZegoCloud Messaging (ZIM)
    Route::prefix('zego/messaging')->name('zego.messaging.')->group(function () {
        // Authentication
        Route::post('/token', [ZegoCloudApiController::class, 'getToken']);
        Route::post('/verify-token', [ZegoCloudApiController::class, 'verifyToken']);

        // User Management
        Route::get('/profile', [ZegoCloudApiController::class, 'getProfile']);
        Route::post('/update-online-status', [ZegoCloudApiController::class, 'updateOnlineStatus']);

        // Contacts
        Route::get('/contacts', [ZegoCloudApiController::class, 'getContacts']);
        Route::get('/users/{user_id}', [ZegoCloudApiController::class, 'getUserDetails']);
        Route::post('/search-users', [ZegoCloudApiController::class, 'searchUsers']);
    });
});

Route::post('auth/g-login-check', [SocialLoginController::class , 'gLoginCheck'])->name('auth.g-login-check');
//zego cloud group call routes starts
Route::prefix('group-call')->name('zego.group.')->middleware(['auth'])->group(function (){
    Route::get('/call-page', [ZegoGroupCallController::class, 'viewCallPage'])->name('call-page');
    Route::post('/initiate', [ZegoGroupCallController::class, 'initiateCall'])->name('initiate');
    Route::post('/{groupCall}/add-participants', [ZegoGroupCallController::class, 'addParticipants'])->name('add-participants');
    Route::post('/{groupCall}/join', [ZegoGroupCallController::class, 'joinCall'])->name('join');
    Route::post('/{groupCall}/reject', [ZegoGroupCallController::class, 'rejectCall'])->name('reject');
    Route::post('/{groupCall}/leave', [ZegoGroupCallController::class, 'leaveCall'])->name('leave');
    Route::post('/{groupCall}/end', [ZegoGroupCallController::class, 'endCall'])->name('end');
    Route::get('/{groupCall}/details', [ZegoGroupCallController::class, 'getCallDetails'])->name('details');
    Route::get('/{groupCall}/participants', [ZegoGroupCallController::class, 'getParticipants'])->name('participants');
    Route::get('/callable-users', [ZegoGroupCallController::class, 'getCallableUsers'])->name('callable-users');
});
