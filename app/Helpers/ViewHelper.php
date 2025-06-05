<?php


namespace App\Helpers;


use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\BatchExamManagement\BatchExamSection;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseClassExamResult;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\ExamManagement\ExamOrder;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Frontend\CourseOrder\CourseOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Xenon\LaravelBDSms\Facades\SMS;

class ViewHelper
{
    protected static $loggedUser, $courseOrder, $examOrder,$examOrders = [], $subscriptionPackage, $subscriptionOrder, $status = 'false';

    public static function checkViewForApi ($data=[], $viewPath = null, $jsonErrorMessage = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            if (str()->contains(url()->current(), '/v1/'))
            {
                if (empty($data))
                {
                    return response()->json(isset($jsonErrorMessage) ? $jsonErrorMessage : 'Something went wrong. Please try again.', 400);
                }
                return response()->json($data, 200);
            }
        } else {

            return view($viewPath, $data);
        }
    }

    public static function returEexceptionError ($message = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            return response()->json(['error' => $message], 400);
        } else {
            return back()->with('error', $message);
        }
    }
    public static function returnSuccessMessage ($message = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            return response()->json(['success' => $message], 200);
        } else {
            return back()->with('success', $message);
        }
    }

    public static function authCheck()
    {
        if (str_contains(url()->current(), '/api/'))
        {
            return auth('sanctum')->check();
        } else {
            return auth()->check();
        }
    }

    public static function loggedUser()
    {
        if (str_contains(url()->current(), '/api/'))
        {
            return auth('sanctum')->user();
        } else {
            return auth()->user();
        }
    }

    public static function checkIfUserHasValidSubscription ()
    {
        if (str_contains(url()->current(), '/api/'))
        {
            self::$loggedUser = auth('sanctum')->user();
        } else {
            self::$loggedUser = auth()->user();
        }
        if (!empty(self::$loggedUser->subscriptionOrders))
        {
            foreach (self::$loggedUser->subscriptionOrders as $subscriptionOrder)
            {
                if ($subscriptionOrder->examSubscriptionPackage->valid_to > Carbon::today()->format('d-m-Y'))
                {
                    self::$status = 'true';
                    break;
                }
            }
        }
        return self::$status;
    }

    public static function sendSms($number = '01646688970', $message = '')
    {
        try {
            SMS::shoot($number, $message);
            return ['status' => 'success'];
        } catch (\Exception $exception)
        {
            return ['status' => 'error', 'msg' => $exception->getMessage()];
        }
    }

    public static function generateOtp($mobile = '01646688970')
    {
        $generate_otp = rand(1000, 9999);
        session()->put('otp', $generate_otp);
        if (str()->contains(url()->current(), '/api/'))
        {
            Cache::put('otp_' . $mobile, $generate_otp, now()->addMinutes(5));
        }
        return $generate_otp;
    }

    public static function getSessionOtp($mobile = '01646688970')
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            $cachedOtp = Cache::get('otp_' . $mobile);
        } else {
            $cachedOtp = session('otp');
        }
        return $cachedOtp;
    }
}
