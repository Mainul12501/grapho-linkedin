<?php

namespace App\Http\Controllers\Backend\Employer;

use App\Http\Controllers\Controller;
use App\Models\Backend\OrderPayment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-views.transactions.index', ['transactions' => OrderPayment::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin-views.transactions.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
        return view('backend.admin-views.transactions.create', [
            'isShown'   => false,
            'subscription' => OrderPayment::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscription)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderPayment $subscription)
    {
        $subscription->delete();
        Toastr::success('Subscription plan deleted successfully.');
        return back();
    }

}
