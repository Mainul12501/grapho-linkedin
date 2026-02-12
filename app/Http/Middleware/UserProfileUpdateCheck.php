<?php

namespace App\Http\Middleware;

use App\Helpers\ViewHelper;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Mainul\CustomHelperFunctions\Helpers\CustomHelper;
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
            if (CustomHelper::isApiRequest() || CustomHelper::isAjax())
            {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please update your profile first.'
                ]);
            } else {
                Toastr::error('Please update your profile first.');
                CustomHelper::returnRedirectWithMessage(route('auth.user-profile-update' ),'error','Please update your profile first.');
            }

            return redirect()->route('auth.user-profile-update');
        }
    }
}
