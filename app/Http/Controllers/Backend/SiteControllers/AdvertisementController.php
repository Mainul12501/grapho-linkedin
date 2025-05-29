<?php

namespace App\Http\Controllers\Backend\SiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Backend\Advertisement;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-views.advertisements.index', ['advertisements' => Advertisement::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin-views.advertisements.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'banner' => 'required|image',
        ]);
        $advertisement = Advertisement::createOrUpdateAdvertisement($request);
        if ($advertisement)
        {
            Toastr::success('Advertisement created successfully.');
            return redirect()->route('advertisements.index');
        }
        else
        {
            Toastr::error('Advertisement creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.admin-views.advertisements.create', [
            'isShown'   => true,
            'advertisement' => Advertisement::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.admin-views.advertisements.create', [
            'isShown'   => false,
            'advertisement' => Advertisement::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
//            'banner' => 'required|string|max:255',
        ]);
        $advertisement = Advertisement::createOrUpdateAdvertisement($request, $advertisement);
        if ($advertisement)
        {
            Toastr::success('Advertisement updated successfully.');
            return redirect()->route('advertisements.index');
        }
        else
        {
            Toastr::error('Advertisement creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();
        Toastr::success('Advertisement deleted successfully.');
        return back();
    }
}
