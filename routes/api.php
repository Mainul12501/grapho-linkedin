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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('send-otp', [CustomLoginController::class, 'sendOtp'])->name('send-otp');


Route::get('get-job-details/{id}', [JobTaskController::class, 'getJobDetails'])->name('get-job-details');

Route::prefix('auth')->name('auth.')->group(function (){
    Route::get('select-auth-method', [CustomLoginController::class, 'selectAuthMethod']);
    Route::get('set-registration-role', [CustomLoginController::class, 'setRegistrationRole']);
    Route::get('set-login-role', [CustomLoginController::class, 'setLoginRole']);
    Route::get('user-login-page', [CustomLoginController::class, 'userLoginPage']);
    Route::get('user-registration-page', [CustomLoginController::class, 'userRegistrationPage']);

    Route::post('custom-registration', [CustomLoginController::class, 'customRegistration']);
    Route::post('custom-login', [CustomLoginController::class, 'customLogin']);

});

Route::middleware([
    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
])->group(function () {

    Route::post('auth/user-password-update', [CustomLoginController::class, 'userPasswordUpdate'])->name('auth.user-password-update');

    Route::prefix('employer')->as('employer.')->middleware('isEmployer')->group(function (){
        Route::get('home', [EmployerViewController::class, 'employerHome']);
        Route::get('my-jobs', [EmployerViewController::class, 'myJobs']);
        Route::get('my-job-wise-applicants', [EmployerViewController::class, 'myJobWiseApplicants']);
        Route::get('my-job-applicants/{jobTask}', [EmployerViewController::class, 'myJobApplicants']);
        Route::get('head-hunt', [EmployerViewController::class, 'headHunt']);
        Route::get('employer-user-management', [EmployerViewController::class, 'employerUserManagement']);
        Route::get('settings', [EmployerViewController::class, 'settings']);
        Route::get('company-profile', [EmployerViewController::class, 'companyProfile']);

        Route::post('update-settings', [EmployerViewController::class, 'updateSettings']);
        Route::post('update-company-info', [EmployerViewController::class, 'updateCompanyInfo']);

        Route::resources([
            'job-tasks'  => JobTaskController::class
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

        Route::post('apply-job/{jobTask}', [EmployeeViewController::class, 'applyJob']);
        Route::post('update-profile/{user}', [EmployeeViewController::class, 'updateProfile']);

//        crud routes
        Route::resources([
            'employee-work-experiences' => EmployeeWorkExperienceController::class,
            'employee-educations' => EmployeeEducationController::class,
            'employee-documents'    => EmployeeDocumentsController::class,
        ]);
    });
});
