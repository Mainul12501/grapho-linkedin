<?php

namespace App\Http\Middleware;

use App\Helpers\ViewHelper;
use App\Models\Backend\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteSubscriptionStatusCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $siteSetting = SiteSetting::select('id','subscription_system_status')->first();
        if ($siteSetting && $siteSetting->subscription_system_status == 1)
        {
            $loggedUser = ViewHelper::loggedUser();
            if ($loggedUser->subscription_end_date < now())
            {
                Toastr::error('currently you do not have any active subscription plan.');
                return redirect('/');
            }
        }
        return $next($request);
    }
}
