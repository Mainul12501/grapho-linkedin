<?php

namespace App\Http\Middleware;

use App\Helpers\ViewHelper;
use App\Models\Backend\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckUserSubscriptionValidityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $siteSettings = \App\Models\Backend\SiteSetting::first();
        $loggedUser = ViewHelper::loggedUser();
        if ($siteSettings && $siteSettings->subscription_system_status == 1)
        {
            if ($loggedUser->subscription_end_date > Carbon::now())
            {
                return $next($request);
            } else {
                return ViewHelper::returEexceptionError('Your subscription expired. Please renew your subscription to continue.');
            }
        } else {
            return $next($request);
        }
    }
}
