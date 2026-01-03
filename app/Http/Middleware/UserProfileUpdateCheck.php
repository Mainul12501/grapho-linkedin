<?php

namespace App\Http\Middleware;

use App\Helpers\ViewHelper;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProfileUpdateCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser->is_profile_updated == 1)
        {
            return $next($request);
        } else {
            Toastr::error('Please update your profile first.');
            return redirect()->route('auth.user-profile-update');
        }
    }
}
