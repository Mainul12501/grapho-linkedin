<?php

namespace App\Http\Controllers\Backend\SiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Backend\CommonPage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommonPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-views.common-pages.index', ['commonPages' => CommonPage::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin-views.common-pages.create', [
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
        $commonPage = CommonPage::createOrUpdateCommonPage($request);
        if ($commonPage)
        {
            Toastr::success('Page created successfully.');
            return redirect()->route('common-pages.index');
        }
        else
        {
            Toastr::error('Page creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.admin-views.common-pages.create', [
            'isShown'   => true,
            'page' => CommonPage::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.admin-views.common-pages.create', [
            'isShown'   => false,
            'page' => CommonPage::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommonPage $commonPage)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $commonPage = CommonPage::createOrUpdateCommonPage($request, $commonPage);
        if ($commonPage)
        {
            Toastr::success('Page updated successfully.');
            return redirect()->route('common-pages.index');
        }
        else
        {
            Toastr::error('Page creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommonPage $commonPage)
    {
        $commonPage->delete();
        Toastr::success('Page deleted successfully.');
        return back();
    }
}
