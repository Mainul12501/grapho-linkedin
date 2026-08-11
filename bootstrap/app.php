<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
            Route::middleware('web')
                ->group(base_path('routes/employee.php'));
            Route::middleware('web')
                ->group(base_path('routes/employer.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            \App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\SetLocalLanguageMiddleware::class,
        ]);
        $middleware->alias([
            'isEmployee'    => \App\Http\Middleware\IsEmployeeMiddleware::class,
            'isEmployer'    => \App\Http\Middleware\IsEmployerMiddleware::class,
            'isAdmin'    => \App\Http\Middleware\IsAdminMiddleware::class,
            'isSuperAdmin'    => \App\Http\Middleware\IsSuperAdminMiddleware::class,
            'CheckUserSubscriptionValidity'    => \App\Http\Middleware\CheckUserSubscriptionValidityMiddleware::class,
            'redirectToHomeOnSessionOut'    => \App\Http\Middleware\RedirectToHomeOnSessionOut::class,
            'setLocalLang'    => \App\Http\Middleware\SetLocalLanguageMiddleware::class,
            'auth-page' => \App\Http\Middleware\AuthPageAuthenticationMiddleware::class,
            'siteSubscriptionStatusCheck' => \App\Http\Middleware\SiteSubscriptionStatusCheck::class,
            'userProfileUpdateCheck' => \App\Http\Middleware\UserProfileUpdateCheck::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'sslcommerz/*',
            'group-call/*',
        ]);
        $middleware->redirectGuestsTo('/');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
