<?php

namespace App\Http\Controllers\Backend\SiteControllers;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\SubscriptionPlan;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-views.subscriptions.index', ['subscriptions' => SubscriptionPlan::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin-views.subscriptions.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'title' => 'required',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'duration_in_days' => 'required|integer|min:0',
        ]);
        $subscription = SubscriptionPlan::createOrUpdateSubscription($request);
        if ($subscription)
        {
            Toastr::success('Subscription Plan created successfully.');
            return redirect()->route('subscriptions.index');
        }
        else
        {
            Toastr::error('Subscription Plan creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.admin-views.subscriptions.create', [
            'isShown'   => true,
            'subscription' => SubscriptionPlan::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.admin-views.subscriptions.create', [
            'isShown'   => false,
            'subscription' => SubscriptionPlan::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscription)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric|min:0',
            'duration_in_days' => 'required|integer|min:0',
        ]);
        $subscription = SubscriptionPlan::createOrUpdateSubscription($request, $subscription);
        if ($subscription)
        {
            Toastr::success('Subscription plan updated successfully.');
            return redirect()->route('subscriptions.index');
        }
        else
        {
            Toastr::error('Subscription creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscription)
    {
        $subscription->delete();
        Toastr::success('Subscription plan deleted successfully.');
        return back();
    }

    public function setSubsToAllUser(Request $request)
    {
        $siteSettings = \App\Models\Backend\SiteSetting::first();
        $users = [];
        if (!$siteSettings || $siteSettings->subscription_system_status == 0)
        {
            return ViewHelper::returEexceptionError('Subscription system is not enabled. Please enable it from site settings first.');
        }
        if ($request->user_type == 'employee')
        {
            $users = \App\Models\User::where('user_type', 'employee')->get(['id', 'subscription_plan_id', 'subscription_end_date']);
        }
        elseif ($request->user_type == 'employer')
        {
            $users = \App\Models\User::where('user_type', 'employer')->get(['id', 'subscription_plan_id', 'subscription_end_date']);
        }
        elseif ($request->user_type == 'all')
        {
            $users = \App\Models\User::whereNotIn('user_type', ['super_admin', 'admin'])->get(['id', 'subscription_plan_id', 'subscription_end_date']);
        }
        if ($users->count() > 0)
        {
            $subscription = SubscriptionPlan::find($request->subscription_plan_id);
            foreach ($users as $user)
            {
                $user->subscription_plan_id = $subscription->id;
                $user->subscription_end_date = Carbon::parse($user->created_at)->addDays($subscription->duration_in_days);
                $user->save();
            }
            return ViewHelper::returnSuccessMessage('Subscription plan set to all users successfully.');
        }
        else
        {
            return ViewHelper::returEexceptionError('No users found for the selected user type.');
        }
    }

    public function showSubscriptionUsers(SubscriptionPlan $subscriptionPlan)
    {
        return view('backend.admin-views.subscriptions.users',[
            'subscription' => $subscriptionPlan,
            'users' => User::whereIn('user_type', ['employee', 'employer'])->where('subscription_plan_id', $subscriptionPlan->id)->get()
        ]);
    }
}
