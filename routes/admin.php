<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RolePermissionManagement\Permission\PermissionCategoryController;
use App\Http\Controllers\Backend\RolePermissionManagement\Permission\PermissionController;
use App\Http\Controllers\Backend\RolePermissionManagement\Role\RoleController;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');

    Route::resources([
        'permission-categories' => PermissionCategoryController::class,
        'permissions' => PermissionController::class,
        'roles' => RoleController::class,
//        'users' => UserController::class,

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
    ]);

});
