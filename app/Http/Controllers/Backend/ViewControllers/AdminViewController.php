<?php

namespace App\Http\Controllers\Backend\ViewControllers;

use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Models\Backend\JobTask;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\OrderPayment;
use App\Models\Backend\Post;
use App\Models\Backend\UserManagement\Student;
use App\Models\Backend\UserManagement\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSectionContent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminViewController extends Controller
{
    protected $data = [];
    public function dashboard ()
    {
        $user = auth()->user();
        $thisMonthTransaction = OrderPayment::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('paid_amount');
        $totalTransaction = OrderPayment::sum('paid_amount');
        $this->data = [
            'loggedInUser' => $user,
            'totalJobs' => JobTask::count(),
            'totalEmployees' => User::where(['user_type' => 'employee'])->count(),
            'totalEmployers' => User::where(['user_type' => 'employer'])->count(),
            'thisMonthTransaction' => $thisMonthTransaction,
            'totalTransaction' => $totalTransaction,
            'latestJobs'    => JobTask::latest()->take(10)->get(['id', 'job_title']),
            'latestPosts'    => Post::latest()->take(10)->get(['id', 'title']),
        ];
        return view('backend.single-view.dashboard.dashboard', $this->data);
    }

    public function changeStatus(Request $request, $id = null)
    {
        $status = '';
        try {
            $object = DB::table($request->model_name)->where('id', $request->id)->first();
            if ($object->status == 1)
            {
                $object = DB::table($request->model_name)->where('id', $request->id)->update(['status' => 0]);
                $status = 'Unpublished';
            } elseif ($object->status == 0)
            {
                $object = DB::table($request->model_name)->where('id', $request->id)->update(['status' => 1]);
                $status = 'Published';
            }
            return response()->json(['status' => 'success', 'message' => $status]);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }
}
