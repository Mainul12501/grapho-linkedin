<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\SSLCommerzController;
use App\Models\Backend\CommonPage;
use App\Models\Backend\SiteSetting;
use App\Models\Backend\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FrontendViewController extends Controller
{
    public function homePage()
    {
        $data = [
            'commonPages'   => CommonPage::where(['status' => 1])->get()
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.home-landing');
        return view('frontend.home-landing');
    }
    public function showCommonPage($slug = null)
    {
        $data = [
            'page'   => CommonPage::where(['slug' => $slug])->first(),
            'commonPages'   => CommonPage::where(['status' => 1])->get()
        ];
        return ViewHelper::checkViewForApi($data, 'frontend.common-page');
        return view('frontend.common-page');
    }

    public function buySubscription(SubscriptionPlan $subscriptionPlan, Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        $data = [];
        $data['user_id']    = $loggedUser->id;
        $data['subscription_id']    = $subscriptionPlan->id;
        $data['redirect_url']    = $request->redirect_url ?? url()->previous();
        $data['total_amount']    = $subscriptionPlan->price ?? 0;
        session()->put('requestData', $data);
        return SSLCommerzController::sendOrderRequestToSSLZ($subscriptionPlan->price ?? 0, $subscriptionPlan->name ?? 'Subscription Plan Title');
//        if ($loggedUser)
//        {
//            $loggedUser->subscription_plan_id  = $subscriptionPlan->id;
//            $loggedUser->subscription_started_from  = now();
//            $loggedUser->subscription_end_date  = Carbon::now()->addDays($subscriptionPlan->duration_in_days ?? 0);
//            $loggedUser->save();
//            return ViewHelper::returnSuccessMessage('Your subscription plan is active.');
//        } else {
//            return ViewHelper::returEexceptionError('Unauthenticated user');
//        }
    }

    public function changeLocalLanguage($lang)
    {
        $locales = [
            'English' => 'en',
            'Bangla' => 'bn'
        ];
        if (array_key_exists($lang, $locales)) {
//            session(['locale' => $locales[$lang]]); // Store 'en' or 'bn', not 'English' or 'Bangla'
            session()->put('locale', $locales[$lang]);
            app()->setLocale($locales[$lang]);
        }
//        return session('locale');
//        return app()->getLocale();
        return back();
    }

    public function getSiteSetting()
    {
        return response()->json(SiteSetting::first());
    }
    public function checkBlockApproveStatus()
    {
        $status = false;
        $loggedUser = ViewHelper::loggedUser();
        if (!$loggedUser)
        {
            return response()->json([
                'status'    => 0,
                'msg' => 'You are not logged in. Please login first.'
            ]);
        }
        if ($loggedUser->is_approved == 0 || $loggedUser->status == 'blocked')
        {
            $status = true;
        } elseif (SiteSetting::first()->subscription_system_status == 1)
        {
            if (Carbon::parse($loggedUser->subscription_end_date) < now())
            {
                $status = true;
            }
        }
        if ($status)
        {
            $data = [
                'status'    => 0,
                'msg' => 'Your account is blocked or has not approved yet or your subscription is expired. Please contact with LikewiseBD.'
            ];
        } else {
            $data = [
                'status'    => 1,
                'msg' => 'Success!! you passed all validations.'
            ];
        }
        return response()->json($data);
    }
}
