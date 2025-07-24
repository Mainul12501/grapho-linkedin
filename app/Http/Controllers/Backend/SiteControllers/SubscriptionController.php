<?php

namespace App\Http\Controllers\Backend\SiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Backend\SubscriptionPlan;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

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
}
