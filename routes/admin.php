<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RolePermissionManagement\Permission\PermissionCategoryController;
use App\Http\Controllers\Backend\RolePermissionManagement\Permission\PermissionController;
use App\Http\Controllers\Backend\RolePermissionManagement\Role\RoleController;
use App\Http\Controllers\Backend\UserManagement\UserController;
use App\Http\Controllers\Backend\ViewControllers\AdminViewController;

use App\Http\Controllers\Backend\Employee\EducationDegreeNameController;
use App\Http\Controllers\Backend\Employee\FieldOfStudyController;
use App\Http\Controllers\Backend\Employee\UniversityNamesController;
use App\Http\Controllers\Backend\Employee\EducationalSubjectNamesController;

use App\Http\Controllers\Backend\Employer\SkillsCategoryController;
use App\Http\Controllers\Backend\Employer\SkillsController;
use App\Http\Controllers\Backend\Employer\IndustryController;
use App\Http\Controllers\Backend\Employer\JobTypeController;
use App\Http\Controllers\Backend\Employer\JobLocationTypeController;
use App\Http\Controllers\Backend\Employer\EmployerCompanyCategoryController;
use App\Http\Controllers\Backend\SiteControllers\AdvertisementController;
use App\Http\Controllers\Backend\SiteControllers\SiteSettingsController;
use App\Http\Controllers\Backend\SiteControllers\SubscriptionController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');
    Route::prefix('admin')->group(function () {
        Route::get('/pending-users', [UserController::class, 'PendingUsers'])->name('pending-users');
        Route::post('/change-user-approve-status/{user}/{status?}', [UserController::class, 'changeUserApproveStatus'])->name('change-user-approve-status');
        Route::get('/view-employer-jobs/{user}', [UserController::class, 'viewEmployerJobs'])->name('view-employer-jobs');
        Route::post('/set-subs-to-all-user', [SubscriptionController::class, 'setSubsToAllUser'])->name('set-subs-to-all-user');
    });

    Route::resources([
        'permission-categories' => PermissionCategoryController::class,
        'permissions' => PermissionController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,

        'education-degree-names' => EducationDegreeNameController::class,
        'field-of-studies' => FieldOfStudyController::class,
        'university-names' => UniversityNamesController::class,
        'educational-subject-names' => EducationalSubjectNamesController::class,

        'skills-categories' => SkillsCategoryController::class,
        'skills' => SkillsController::class,
        'industries' => IndustryController::class,
        'job-types' => JobTypeController::class,
        'job-location-types' => JobLocationTypeController::class,
        'employer-company-categories' => EmployerCompanyCategoryController::class,
        'advertisements' => AdvertisementController::class,
        'site-settings' => SiteSettingsController::class,
        'subscriptions' => SubscriptionController::class,
    ]);

});
