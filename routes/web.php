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


Route::get('/', [FrontendViewController::class, 'homePage'])->name('/');

Route::get('employee-profile/{employeeId}', [EmployerViewController::class, 'employeeProfile'])->name('employee-profile');

Route::get('auth/{provider}/redirect', [SocialLoginController::class , 'redirect'])->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class , 'callback'])->name('auth.socialite.callback');
Route::post('send-otp', [CustomLoginController::class, 'sendOtp'])->name('send-otp');
Route::post('buy-subscription/{subscriptionPlan}', [FrontendViewController::class, 'buySubscription'])->name('buy-subscription');


Route::get('get-job-details/{id}', [JobTaskController::class, 'getJobDetails'])->name('get-job-details');

Route::prefix('auth')->name('auth.')->group(function (){
    Route::get('select-auth-method', [CustomLoginController::class, 'selectAuthMethod'])->name('select-auth-method');
    Route::get('set-registration-role', [CustomLoginController::class, 'setRegistrationRole'])->name('set-registration-role');
    Route::get('set-login-role', [CustomLoginController::class, 'setLoginRole'])->name('set-login-role');
    Route::get('user-login-page', [CustomLoginController::class, 'userLoginPage'])->name('user-login-page');
    Route::get('user-registration-page', [CustomLoginController::class, 'userRegistrationPage'])->name('user-registration-page');

    Route::post('custom-registration', [CustomLoginController::class, 'customRegistration'])->name('custom-registration');
    Route::post('custom-login', [CustomLoginController::class, 'customLogin'])->name('custom-login');


});

Route::post('sslcommerz/success',[SSLCommerzController::class, 'paymentSuccess'])->name('payment.success');
Route::post('sslcommerz/failure',[SSLCommerzController::class, 'paymentFailure'])->name('payment.failure');
Route::post('sslcommerz/cancel',[SSLCommerzController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('sslcommerz/ipn',[SSLCommerzController::class, 'ipn'])->name('payment.ipn');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'redirectToHomeOnSessionOut',
])->group(function () {

    Route::post('auth/user-password-update', [CustomLoginController::class, 'userPasswordUpdate'])->name('auth.user-password-update');

    Route::prefix('employer')->as('employer.')->middleware('isEmployer')->group(function (){
        Route::get('home', [EmployerViewController::class, 'employerHome'])->name('home');
        Route::get('my-jobs', [EmployerViewController::class, 'myJobs'])->name('my-jobs');
        Route::get('my-job-wise-applicants', [EmployerViewController::class, 'myJobWiseApplicants'])->name('my-job-wise-applicants');
        Route::get('my-job-applicants/{jobTask}', [EmployerViewController::class, 'myJobApplicants'])->name('my-job-applicants');
        Route::get('head-hunt', [EmployerViewController::class, 'headHunt'])->name('head-hunt');
        Route::get('employer-user-management', [EmployerViewController::class, 'employerUserManagement'])->name('employer-user-management');
        Route::get('settings', [EmployerViewController::class, 'settings'])->name('settings');
        Route::get('company-profile', [EmployerViewController::class, 'companyProfile'])->name('company-profile');
        Route::get('change-sub-employer-status/{user}/{status}', [EmployerViewController::class, 'changeSubEmployerStatus'])->name('change-sub-employer-status');
        Route::get('change-employee-job-application-status/{jobTask}/{user}/{status?}', [EmployerViewController::class, 'changeEmployeeJobApplicationStatus'])->name('change-employee-job-application-status');
        Route::get('employer-subscriptions', [EmployerViewController::class, 'employerSubscriptions'])->name('employer-subscriptions');

        Route::post('update-settings', [EmployerViewController::class, 'updateSettings'])->name('update-settings');
        Route::post('update-company-info', [EmployerViewController::class, 'updateCompanyInfo'])->name('update-company-info');
        Route::post('create-sub-user', [EmployerViewController::class, 'createSubUser'])->name('create-sub-user');
        Route::post('delete-sub-employer/{user}', [EmployerViewController::class, 'deleteSubEmployer'])->name('delete-sub-employer');

        Route::resources([
            'job-tasks'  => JobTaskController::class,
            'posts'  => PostController::class
        ]);
    });
    Route::prefix('employee')->as('employee.')->middleware('isEmployee')->group(function (){
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

        Route::post('apply-job/{jobTask}', [EmployeeViewController::class, 'applyJob'])->name('apply-job');
        Route::post('update-profile/{user}', [EmployeeViewController::class, 'updateProfile'])->name('update-profile');
//        crud routes
        Route::resources([
            'employee-work-experiences' => EmployeeWorkExperienceController::class,
            'employee-educations' => EmployeeEducationController::class,
            'employee-documents'    => EmployeeDocumentsController::class,
        ]);
    });
});

