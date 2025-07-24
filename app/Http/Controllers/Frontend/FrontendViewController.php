<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FrontendViewController extends Controller
{
    public function homePage()
    {
        return view('frontend.home-landing');
    }

    public function buySubscription(SubscriptionPlan $subscriptionPlan, Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        if ($loggedUser)
        {
            $loggedUser->subscription_plan_id  = $subscriptionPlan->id;
            $loggedUser->subscription_started_from  = now();
            $loggedUser->subscription_end_date  = Carbon::now()->addDays($subscriptionPlan->duration_in_days ?? 0);
            $loggedUser->save();
            return ViewHelper::returnSuccessMessage('Your subscription plan is active.');
        } else {
            return ViewHelper::returEexceptionError('Unauthenticated user');
        }
    }
}
