<?php

namespace App\Http\Middleware;

use App\Helpers\ViewHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsEmployerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loggedInUser = ViewHelper::loggedUser();
        if ($loggedInUser->user_type == 'employer' || $loggedInUser->user_type == 'sub_employer'){
            return $next($request);
        } else {
            return ViewHelper::returnRedirectWithMessage(route('/'), 'error', 'Access Denied! You are not authorized to access that page.');
        }
    }
}
