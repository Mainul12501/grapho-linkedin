<?php

namespace App\Http\Controllers\Frontend\Crud;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\FollowerHistory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class FollowerHistroyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $loggedUser = ViewHelper::loggedUser();
        $existFollowHistory = FollowerHistory::where(['employer_id' => $request->employer_id, 'follower_id' => $loggedUser->id])->first();
        if ($request->status == 'false')
        {
            $existFollowHistory->delete();
            Toastr::success('Employer unfollowed successfully.');
            return response()->json(['status' => 'success', 'msg' => 'Employer unfollowed successfully', 'follow_status' => 0]);
        } else {
            if (!$existFollowHistory)
            {
                $followHistory = new FollowerHistory();
                $followHistory->employer_id = $request->employer_id;
                $followHistory->follower_id = $loggedUser->id;
                $followHistory->save();
                Toastr::success('Employer followed successfully.');
                return response()->json(['status' => 'success', 'msg' => 'Employer followed successfully.', 'follow_status' => 1]);
            } else {
                return response()->json(['status' => 'error', 'msg' => 'Employer already followed.']);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
