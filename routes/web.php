<?php

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
use App\Http\Controllers\Payment\SSLCommerzController;
use App\Http\Controllers\Frontend\Crud\PostController;
use App\Http\Controllers\Frontend\Crud\FollowerHistroyController;
use App\Http\Controllers\Frontend\Twilio\TwilioVideoController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Frontend\ZegoCloud\ZegoCloudController;
use App\Http\Controllers\Frontend\ZegoCloud\ZegoCloudMessagingController;

Route::get('change-local-language/{local}', [FrontendViewController::class, 'changeLocalLanguage'])->name('change-local-language');

Route::get('/', [FrontendViewController::class, 'homePage'])->name('/');
Route::get('/page/{slug?}', [FrontendViewController::class, 'showCommonPage'])->name('show-common-page');

Route::get('employee-profile/{employeeId}', [EmployerViewController::class, 'employeeProfile'])->name('employee-profile');

Route::get('auth/{provider}/redirect', [SocialLoginController::class , 'redirect'])->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class , 'callback'])->name('auth.socialite.callback');
Route::post('send-otp', [CustomLoginController::class, 'sendOtp'])->name('send-otp');
Route::post('verify-otp', [CustomLoginController::class, 'verifyOtp'])->name('verify-otp');
Route::post('buy-subscription/{subscriptionPlan}', [FrontendViewController::class, 'buySubscription'])->name('buy-subscription');
Route::get('/pass', function (){
    return bcrypt('password');
});

Route::get('get-job-details/{id}', [JobTaskController::class, 'getJobDetails'])->name('get-job-details');

Route::prefix('auth')->name('auth.')->middleware('auth-page')->group(function (){
    Route::get('select-auth-method', [CustomLoginController::class, 'selectAuthMethod'])->name('select-auth-method');
    Route::get('set-registration-role', [CustomLoginController::class, 'setRegistrationRole'])->name('set-registration-role');
    Route::get('set-login-role', [CustomLoginController::class, 'setLoginRole'])->name('set-login-role');
    Route::get('user-login-page', [CustomLoginController::class, 'userLoginPage'])->name('user-login-page');
    Route::get('user-registration-page', [CustomLoginController::class, 'userRegistrationPage'])->name('user-registration-page');

    Route::post('custom-registration', [CustomLoginController::class, 'customRegistration'])->name('custom-registration');
    Route::post('custom-login', [CustomLoginController::class, 'customLogin'])->name('custom-login');

    Route::get('forgot-password-page', [CustomLoginController::class, 'forgotPasswordPage'])->name('forgot-password-page');
    Route::post('send-forgot-password-otp', [CustomLoginController::class, 'sendForgotPasswordOtp'])->name('send-forgot-password-otp');
    Route::post('verify-forgot-password-otp', [CustomLoginController::class, 'verifyForgotPasswordOtp'])->name('verify-forgot-password-otp');
    Route::post('reset-password', [CustomLoginController::class, 'resetPassword'])->name('reset-password');
});

Route::post('sslcommerz/success',[SSLCommerzController::class, 'paymentSuccess'])->name('payment.success');
Route::post('sslcommerz/failure',[SSLCommerzController::class, 'paymentFailure'])->name('payment.failure');
Route::post('sslcommerz/cancel',[SSLCommerzController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('sslcommerz/ipn',[SSLCommerzController::class, 'ipn'])->name('payment.ipn');

//twilio video page routes
Route::get('/view-twilio-video-page', [TwilioVideoController::class, 'viewPage'])->name('twilio.view');
Route::post('/video/token', [TwilioVideoController::class, 'token'])->name('video.token');
Route::post('/audio/token', [TwilioVideoController::class, 'audioToken'])->name('audio.token');
// Protected (host actions) -- twilio

//zego cloud video and audio page routes starts
Route::prefix('call')->name('zego.')->middleware(['auth'])->group(function (){
    Route::get('/call-page', [ZegoCloudController::class, 'viewCallPage'])->name('call-page');
    Route::post('/initiate', [ZegoCloudController::class, 'initiateCall'])->name('initiate');
    Route::post('/{call}/accept', [ZegoCloudController::class, 'acceptCall'])->name('accept');
    Route::post('/{call}/reject', [ZegoCloudController::class, 'rejectCall'])->name('reject');
    Route::post('/{call}/end', [ZegoCloudController::class, 'endCall'])->name('end');
    Route::get('/{call}/details', [ZegoCloudController::class, 'getCallDetails'])->name('details');
    Route::post('/generate-token', [ZegoCloudController::class, 'generateToken'])->name('generate-token');
});
//zego cloud video and audio page routes ends


Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/twilio/invite', [TwilioVideoController::class, 'inviteCreate'])->name('twilio.invite');
    Route::post('/twilio/kick', [TwilioVideoController::class, 'kickParticipant'])->name('twilio.kick');
    Route::get('/twilio/logs', [TwilioVideoController::class, 'logs'])->name('twilio.logs');
    Route::post('/twilio/mark-started', [TwilioVideoController::class, 'markStarted'])->name('twilio.markStarted');
    Route::post('/twilio/complete', [TwilioVideoController::class, 'completeRoom'])->name('twilio.complete');
});


//zego-cloud msg integration test
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'redirectToHomeOnSessionOut',
])->prefix('zego')->name('zego-message.')->group(function (){
    Route::get('/chat', [ZegoCloudMessagingController::class, 'index'])->name('chat');
    Route::post('/get-token', [ZegoCloudMessagingController::class, 'getToken'])->name('get-token');
    Route::get('/get-contacts', [ZegoCloudMessagingController::class, 'getContacts'])->name('get-contacts');
    Route::get('/diagnostic', [ZegoCloudMessagingController::class, 'diagnostic'])->name('diagnostic');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'redirectToHomeOnSessionOut',
])->group(function () {

    Route::get('auth/user-profile-update', [CustomLoginController::class, 'userProfileUpdate'])->name('auth.user-profile-update');
    Route::post('update-fcm-token', [CustomLoginController::class, 'updateFcmToken'])->name('update-fcm-token');
    Route::post('update-zego-caller-id', [CustomLoginController::class, 'updateZegoCallerId'])->name('update-zego-caller-id');

    Route::post('auth/user-password-update', [CustomLoginController::class, 'userPasswordUpdate'])->name('auth.user-password-update');
    Route::get('call-user/{type?}', [TwilioVideoController::class, 'viewPage'])->name('employer.call-user');
    Route::get('view-company-profile/{employerCompany}', [EmployeeViewController::class, 'viewCompanyProfile'])->name('view-company-profile');

    Route::prefix('employer')->as('employer.')->middleware(['isEmployer', 'siteSubscriptionStatusCheck'])->group(function (){
        Route::get('home', [EmployerViewController::class, 'employerHome'])->name('home');
        Route::get('dashboard', [EmployerViewController::class, 'dashboard'])->name('dashboard');
        Route::get('my-jobs', [EmployerViewController::class, 'myJobs'])->name('my-jobs');
        Route::get('my-job-wise-applicants', [EmployerViewController::class, 'myJobWiseApplicants'])->name('my-job-wise-applicants');
        Route::get('my-job-applicants/{jobTask}', [EmployerViewController::class, 'myJobApplicants'])->name('my-job-applicants');
        Route::get('head-hunt', [EmployerViewController::class, 'headHunt'])->name('head-hunt');
        Route::get('employer-user-management', [EmployerViewController::class, 'employerUserManagement'])->name('employer-user-management');
        Route::get('get-employer-user-info/{user}', [EmployerViewController::class, 'employerUserInfo'])->name('get-employer-user-info');
        Route::get('settings', [EmployerViewController::class, 'settings'])->name('settings');
        Route::get('company-profile', [EmployerViewController::class, 'companyProfile'])->name('company-profile');
        Route::get('change-sub-employer-status/{user}/{status}', [EmployerViewController::class, 'changeSubEmployerStatus'])->name('change-sub-employer-status');
        Route::get('change-employee-job-application-status/{jobTask}/{user}/{status?}', [EmployerViewController::class, 'changeEmployeeJobApplicationStatus'])->name('change-employee-job-application-status');
        Route::get('employer-subscriptions', [EmployerViewController::class, 'employerSubscriptions'])->name('employer-subscriptions');
        Route::get('view-post/{post}', [PostController::class, 'viewPost'])->name('view-post');
        Route::get('close-job/{jobTask}/{status}', [JobTaskController::class, 'closeJob'])->name('close-job');
        Route::get('set-follow-history', [FollowerHistroyController::class, 'store'])->name('set-follow-history');
        Route::get('my-notifications', [EmployerViewController::class, 'myNotifications'])->name('my-notifications');
        Route::get('employee-suggestions', [EmployerViewController::class, 'employeeSuggestions'])->name('employee-suggestions');

        Route::post('update-settings', [EmployerViewController::class, 'updateSettings'])->name('update-settings');
        Route::post('update-company-info', [EmployerViewController::class, 'updateCompanyInfo'])->name('update-company-info');
        Route::post('create-sub-user', [EmployerViewController::class, 'createSubUser'])->name('create-sub-user');
        Route::put('update-sub-user/{user}', [EmployerViewController::class, 'updateSubUser'])->name('update-sub-user');
        Route::post('delete-sub-employer/{user}', [EmployerViewController::class, 'deleteSubEmployer'])->name('delete-sub-employer');

        Route::resources([
            'job-tasks'  => JobTaskController::class,
            'posts'  => PostController::class
        ]);
    });
    Route::prefix('employee')->as('employee.')->middleware(['isEmployee', 'siteSubscriptionStatusCheck'])->group(function (){
        Route::get('home', [EmployeeViewController::class, 'employeeHome'])->name('home');
        Route::get('show-jobs', [EmployeeViewController::class, 'showJobs'])->name('show-jobs');
        Route::get('my-saved-jobs', [EmployeeViewController::class, 'mySavedJobs'])->name('my-saved-jobs');
        Route::get('my-applications', [EmployeeViewController::class, 'myApplications'])->name('my-applications');
        Route::get('my-profile-viewers', [EmployeeViewController::class, 'myProfileViewers'])->name('my-profile-viewers');
        Route::get('my-subscriptions', [EmployeeViewController::class, 'mySubscriptions'])->name('my-subscriptions');
        Route::get('settings', [EmployeeViewController::class, 'settings'])->name('settings');
        Route::get('my-profile', [EmployeeViewController::class, 'myProfile'])->name('my-profile');
        Route::get('my-notifications', [EmployeeViewController::class, 'myNotifications'])->name('my-notifications');
        Route::get('save-job/{jobTask}', [EmployeeViewController::class, 'saveJob'])->name('save-job');
        Route::get('delete-saved-job/{jobTask}', [EmployeeViewController::class, 'deleteSaveJob'])->name('delete-saved-job');
        Route::get('change-job-active-status/{status}', [EmployeeViewController::class, 'changeJobActiveStatus'])->name('change-job-active-status');
        Route::get('get-total-saved-jobs', [EmployeeViewController::class, 'getTotalSavedJobs'])->name('get-total-saved-jobs');


        Route::post('make-msg-seen/{web_notification_id}', [EmployeeViewController::class, 'makeMsgSeen'])->name('make-msg-seen');
        Route::post('apply-job/{jobTask}', [EmployeeViewController::class, 'applyJob'])->name('apply-job');
        Route::post('update-profile/{user}', [EmployeeViewController::class, 'updateProfile'])->name('update-profile');
        Route::post('update-employee-info', [EmployeeViewController::class, 'updateEmployeeInfo'])->name('update-employee-info');
//        crud routes
        Route::resources([
            'employee-work-experiences' => EmployeeWorkExperienceController::class,
            'employee-educations' => EmployeeEducationController::class,
            'employee-documents'    => EmployeeDocumentsController::class,
        ]);
    });
});





/* create symbolic link */
Route::get('/symlink', function () {
    Artisan::call('storage:link');
    echo Artisan::output();
});

Route::get('/clear-all-cache', function () {
    Artisan::call('optimize:clear');
    return Artisan::output();
})->name('clear-all-cache');

Route::get('/run-db-seeder', function () {
    Artisan::call('db:seed');
    return Artisan::output();
})->name('run-db-seeder');

Route::get('/phpinfo', function () {
    phpinfo();
});



