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

    public function dashboard2()
    {
        $user = auth()->user();

        // Basic stats
        $totalJobs = JobTask::count();
        $totalEmployees = User::where('user_type', 'employee')->count();
        $totalEmployers = User::where('user_type', 'employer')->count();
        $totalPosts = Post::count();

        // Transaction stats
        $thisMonthTransaction = OrderPayment::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('paid_amount');
        $totalTransaction = OrderPayment::sum('paid_amount');
        $totalOrders = OrderPayment::count();
        $completedOrders = OrderPayment::where('payment_status', 'completed')->count();

        // Monthly revenue data for last 12 months (for area chart)
        $monthlyRevenue = [];
        $monthlyOrders = [];
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            $monthlyRevenue[] = (float) OrderPayment::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('paid_amount');
            $monthlyOrders[] = (int) OrderPayment::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // User registration trend (last 12 months)
        $monthlyEmployees = [];
        $monthlyEmployers = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyEmployees[] = (int) User::where('user_type', 'employee')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $monthlyEmployers[] = (int) User::where('user_type', 'employer')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // Jobs posted per month (last 12 months)
        $monthlyJobs = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyJobs[] = (int) JobTask::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // Payment method distribution (for pie chart)
        $paymentMethods = OrderPayment::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => ucfirst($item->payment_method ?? 'Unknown'),
                    'y' => (int) $item->count
                ];
            })->toArray();

        // Recent transactions
        $recentTransactions = OrderPayment::with(['user', 'subscriptionPlan'])
            ->latest()
            ->take(10)
            ->get();

        // Latest jobs and posts
        $latestJobs = JobTask::with('Employer')->latest()->take(5)->get();
        $latestPosts = Post::with('employer')->latest()->take(5)->get();

        // New users this week
        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Active jobs (not expired)
        $activeJobs = JobTask::where('deadline', '>=', Carbon::now())->count();

        // Growth percentages (comparing this month to last month)
        $lastMonthRevenue = OrderPayment::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('paid_amount');
        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($thisMonthTransaction - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : ($thisMonthTransaction > 0 ? 100 : 0);

        $lastMonthUsers = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();
        $thisMonthUsers = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $userGrowth = $lastMonthUsers > 0
            ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1)
            : ($thisMonthUsers > 0 ? 100 : 0);

        $this->data = [
            'loggedInUser' => $user,
            'totalJobs' => $totalJobs,
            'totalEmployees' => $totalEmployees,
            'totalEmployers' => $totalEmployers,
            'totalPosts' => $totalPosts,
            'thisMonthTransaction' => $thisMonthTransaction,
            'totalTransaction' => $totalTransaction,
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'months' => $months,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyOrders' => $monthlyOrders,
            'monthlyEmployees' => $monthlyEmployees,
            'monthlyEmployers' => $monthlyEmployers,
            'monthlyJobs' => $monthlyJobs,
            'paymentMethods' => $paymentMethods,
            'recentTransactions' => $recentTransactions,
            'latestJobs' => $latestJobs,
            'latestPosts' => $latestPosts,
            'newUsersThisWeek' => $newUsersThisWeek,
            'activeJobs' => $activeJobs,
            'revenueGrowth' => $revenueGrowth,
            'userGrowth' => $userGrowth,
        ];

        return view('backend.single-view.dashboard.dashboard2', $this->data);
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
