<?php

namespace App\Http\Controllers\Backend\SiteControllers;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-views.site-setting.create', ['basicSetting' => SiteSetting::first()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_title'    => 'required',
        ]);
        SiteSetting::createOrUpdateSiteSetting($request);
//        Toastr::success('Site Setting data stored successfully.');
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax(['status' => 'success', 'msg' => 'Site Setting data stored successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->index();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->index();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'site_title'    => 'required',
        ]);
        SiteSetting::createOrUpdateSiteSetting($request);
        return ViewHelper::returnBackViewAndSendDataForApiAndAjax(['status' => 'success', 'msg' => 'Site Setting data stored successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return back();
    }
}
