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
use App\Http\Controllers\Backend\SiteControllers\CommonPageController;
use App\Http\Controllers\Backend\Employer\TransactionController;
use App\Http\Controllers\Backend\SiteController\SendNotificationController;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isAdmin'
])->group(function () {

    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');
    Route::prefix('admin')->group(function () {
        Route::get('/pending-users', [UserController::class, 'PendingUsers'])->name('pending-users');
        Route::post('/change-user-approve-status/{user}/{status?}', [UserController::class, 'changeUserApproveStatus'])->name('change-user-approve-status');
        Route::get('/view-employer-jobs/{user}', [UserController::class, 'viewEmployerJobs'])->name('view-employer-jobs');
        Route::get('/view-employer-posts/{user}', [UserController::class, 'viewEmployerPosts'])->name('view-employer-posts');
        Route::post('/delete-post-admin/{post}', [\App\Http\Controllers\Frontend\Crud\PostController::class, 'destroy'])->name('delete-post-admin');
        Route::post('/set-subs-to-all-user', [SubscriptionController::class, 'setSubsToAllUser'])->name('set-subs-to-all-user');
        Route::get('/show-subscription-users/{subscriptionPlan}', [SubscriptionController::class, 'showSubscriptionUsers'])->name('show-subscription-users');
        Route::post('/send-notification-to-user-by-method/{sendNotification}', [SendNotificationController::class, 'sendNotificationToUser'])->name('send-notification-to-user-by-method');
        Route::post('/set-user-subscription-plan', [UserController::class, 'setUserSubscriptionPlan'])->name('set-user-subscription-plan');
        Route::post('/update-vendor-credentials', [SiteSettingsController::class, 'updateVendorCredentials'])->name('update-vendor-credentials');
    });

    Route::resources([
        'permission-categories' => PermissionCategoryController::class,
        'permissions' => PermissionController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
        'common-pages' => CommonPageController::class,

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
        'transactions' => TransactionController::class,

        'send-notifications' => SendNotificationController::class,
    ]);

});
