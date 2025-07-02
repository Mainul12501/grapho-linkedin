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
        ]);
        $middleware->alias([
            'isEmployee'    => \App\Http\Middleware\IsEmployeeMiddleware::class,
            'isEmployer'    => \App\Http\Middleware\IsEmployerMiddleware::class,
            'redirectToHomeOnSessionOut'    => \App\Http\Middleware\RedirectToHomeOnSessionOut::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
