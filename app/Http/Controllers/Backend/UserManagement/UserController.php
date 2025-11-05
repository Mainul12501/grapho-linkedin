<?php

namespace App\Http\Controllers\Backend\UserManagement;

use App\DataTables\UsersDataTable;
use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $users = [];
    protected $data = [];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, UsersDataTable $usersDataTable)
    {
//        return $usersDataTable->render('backend.user-management.user.index'/*, $this->data*/);
//        if ($request->ajax()) {
//            return $usersDataTable->render('backend.user-management.index', $this->data);
//        }
        if ($request->user_type == 'admin')
        {
            $this->users = User::where(['user_type' => 'admin'])->get();
        } elseif ($request->user_type == 'employer')
        {
            if ($request->has('show_sub_employer') && $request->show_sub_employer == 1 && $request->has('employer_id'))
            {
                $this->users = User::where(['user_type' => 'sub_employer', 'user_id' => $request->employer_id])->get();
            } else {
                $this->users = User::where(['user_type' => 'employer'])->get();
            }
        } elseif ($request->user_type == 'employee')
        {
            $this->users = User::where(['user_type' => 'employee'])->get();
        } else {
            $this->users = User::take(200)->get();
        }
        $this->data = [
            'users' => $this->users,
            'userType' => $request->user_type ?? 'all',
        ];
        return ViewHelper::checkViewForApi($this->data, 'backend.user-management.user.index');
        return view('backend.user-management.user.index');
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
        //
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
    public function destroy(User $user, Request $request)
    {
        if ($user)
        {
            if (isset($request->req_for) && $request->req_for == 'block')
            {
                $user->status = 'blocked';
                $user->save();
                Toastr::success('User Blocked Successfully.');
            } elseif (isset($request->req_for) && $request->req_for == 'unblock')
            {
                $user->status = null;
                $user->save();
                Toastr::success('User Blocked Successfully.');
            } elseif (isset($request->req_for) && $request->req_for == 'delete') {
                $user->delete();
                Toastr::success('User Deleted Successfully.');
            } else {
                Toastr::error('Something went wrong. Please try again.');
            }
            return back();
        } else {
            return ViewHelper::returEexceptionError('User not found.');
        }
    }

    public function PendingUsers()
    {
        $this->data = [
            'pendingUsers' => User::where(['user_type' => 'employer', 'is_approved' => 0])->get(['id', 'name', 'mobile', 'email', 'user_type', 'employer_company_id']),
        ];
        return ViewHelper::checkViewForApi($this->data, 'backend.user-management.pending-users');
        return view('backend.user-management.pending-users');
    }

    public function changeUserApproveStatus(User $user, $status = 0)
    {
        $user->update(['is_approved' => $status]);
        return ViewHelper::returnSuccessMessage('User approval status updated successfully.');
    }

    public function viewEmployerJobs(User $user)
    {
        $this->data = [
            'user' => $user,
            'jobs' => $user->jobs()->get(),
        ];
        return ViewHelper::checkViewForApi($this->data, 'backend.user-management.view-employer-jobs');
        return view('backend.user-management.view-employer-jobs');
    }
}
