<?php


namespace App\Helpers;

use App\Models\Backend\EmployeeAppliedJob;
use Brian2694\Toastr\Facades\Toastr;
use http\Client\Request;
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
//            if (str()->contains(url()->current(), '/v1/'))
//            {
                if (empty($data))
                {
                    return response()->json(isset($jsonErrorMessage) ? $jsonErrorMessage : 'Something went wrong. Please try again.', 400);
                }
                return response()->json($data, 200);
//            }
        } else {

            return view($viewPath, $data);
        }
    }

    public static function returnDataForAjaxAndApi($data = [])
    {
        if (empty($data))
        {
            return response()->json(isset($jsonErrorMessage) ? $jsonErrorMessage : 'Something went wrong. Please try again.', 400);
        }
        return response()->json($data, 200);
        if (str()->contains(url()->current(), '/api/'))
        {
//            if (str()->contains(url()->current(), '/v1/'))
//            {

                return response()->json($data, 200);
//            }
        } else {

            return response()->json($data);
        }
    }

    public static function returEexceptionError ($message = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            return response()->json(['error' => $message, 'status' => 'error'], 400);
        } else {
            Toastr::error($message);
            return back()->with('error', $message);
        }
    }

    public static function returnResponseFromPostRequest($status = false, $message = '')
    {
        if (str()->contains(url()->current(), '/api/') || \request()->ajax())
        {
            return response()->json(['status' => 'success', 'msg' => $message]);
        } else {
            Toastr::success($message);
            return back();
        }
    }
    public static function returnSuccessMessage ($message = null)
    {
        if (str()->contains(url()->current(), '/api/') || \request()->ajax())
        {
            return response()->json(['success' => $message, 'status' => 'success'], 200);
        } else {
            Toastr::success($message);
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

    public static function getJobSaveApplyInfo($id)
    {
        $isSaved = false;
        $isApplied = false;
        if (ViewHelper::loggedUser())
        {
            $user = ViewHelper::loggedUser();
            if ($user->roles[0]->id == 3 )
            {
                $savedJobsIds = $user->employeeSavedJobs->pluck('id')->toArray();
                $isSaved = in_array($id, $savedJobsIds);
                if (EmployeeAppliedJob::where(['user_id' => $user->id, 'job_task_id' => $id])->first())
                    $isApplied = true;
            }
        }
        return [
            'isSaved'   => $isSaved,
            'isApplied'   => $isApplied,
        ];
    }
}
