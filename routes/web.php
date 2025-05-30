<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\FrontendViewController;
use App\Http\Controllers\Frontend\EmployerViewController;



Route::get('/', [FrontendViewController::class, 'homePage'])->name('/');

Route::get('employee-profile', [EmployerViewController::class, 'employeeProfile'])->name('employee-profile');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('employer')->as('employer.')->middleware('isEmployer')->group(function (){
       Route::get('home', [EmployerViewController::class, 'employerHome'])->name('home');
       Route::get('my-jobs', [EmployerViewController::class, 'myJobs'])->name('my-jobs');
       Route::get('my-job-wise-applicants', [EmployerViewController::class, 'myJobWiseApplicants'])->name('my-job-wise-applicants');
       Route::get('my-job-applicants', [EmployerViewController::class, 'myJobApplicants'])->name('my-job-applicants');
       Route::get('head-hunt', [EmployerViewController::class, 'headHunt'])->name('head-hunt');
       Route::get('employer-user-management', [EmployerViewController::class, 'employerUserManagement'])->name('employer-user-management');
       Route::get('settings', [EmployerViewController::class, 'settings'])->name('settings');
       Route::get('company-profile', [EmployerViewController::class, 'companyProfile'])->name('company-profile');
    });

});
