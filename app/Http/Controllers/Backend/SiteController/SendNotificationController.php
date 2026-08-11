<?php

namespace App\Http\Controllers\Backend\SiteController;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationEmail;
use App\Models\Backend\SiteSetting;
use App\Models\SendNotification;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.admin-views.send-notification.index', ['notifications' => SendNotification::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin-views.send-notification.create', [
            'isShown'   => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'msg' => 'required',
        ]);
        $sendNotification = SendNotification::createOrUpdateSendNotification($request);
        if ($sendNotification)
        {
            Toastr::success('Notification message created successfully.');
            return redirect()->route('send-notifications.index');
        }
        else
        {
            Toastr::error('Notification message creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('backend.admin-views.send-notification.create', [
            'isShown'   => true,
            'notification' => SendNotification::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('backend.admin-views.send-notification.create', [
            'isShown'   => false,
            'notification' => SendNotification::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SendNotification $sendNotification)
    {
        $request->validate([
            'msg' => 'required',
        ]);
        $sendNotification = SendNotification::createOrUpdateSendNotification($request, $sendNotification);
        if ($sendNotification)
        {
            Toastr::success('Notification updated successfully.');
            return redirect()->route('send-notifications.index');
        }
        else
        {
            Toastr::error('Notification creation failed. Please Try Again.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendNotification $sendNotification)
    {
        $sendNotification->delete();
        Toastr::success('Notification message deleted successfully.');
        return back();
    }

    public function sendNotificationToUser(Request $request, $notificationId)
    {
        $notification = SendNotification::find($notificationId);
        if ($notification)
        {
            $users = User::query();
            if ($notification->send_user_type == 'employee')
            {
                $users = $users->where('user_type', 'employee');
            } elseif ($notification->send_user_type == 'employer')
            {
                $users = $users->where('user_type', 'employer')->orWhere('user_type', 'sub_employer');
            } elseif ($notification->send_user_type == 'user')
            {
                $users = $users->where('user_type', 'user');
            } elseif ($notification->send_user_type == 'admin')
            {
                $users = $users->where('user_type', 'admin');
            } else if ($notification->send_user_type == 'all')
            {
                $users = $users->where('user_type', '!=', 'super_admin');
            }
            $users = $users->get();


            try {
                if ($notification->method == 'mobile')
                {
                    $mobileNumberString = $users->pluck('mobile')->filter()->unique()->implode(',');
                    $sms = ViewHelper::sendSms($mobileNumberString, html_entity_decode($notification->msg));
                    Toastr::success('Message sent successfully.');
                } elseif ($notification->method == 'email')
                {
                    $data = [
                        'msg'  => $notification->msg,
                        'siteSetting'   => SiteSetting::first(),
                    ];
                    $emails = $users->pluck('email')->filter()->unique();
                    $errors = '';
                    foreach ($emails as $email)
                    {
//                        without queue
//                        try {
//                            Mail::send('backend.admin-views.send-notification.msg', $data, function ($message) use ($data, $email){
//                                $message->to($email, 'Like Wise Bd')->subject('Notification Message');
//                            });
//                        }  catch (\Exception $e) {
//                            // Handle any other errors
//                            $errors .= "Failed to send email to {$email}<br>";
//                            \Log::error("Failed to send email to {$email}: " . $e->getMessage());
//                        }

//                        with queue
                        SendNotificationEmail::dispatch($email, $data);
                        ViewHelper::startQueueWorkManuallyByArtisanCommand();

                    }
                    if ($errors) {
                        Toastr::error($errors);
                    } else {
                        Toastr::success('Message sent successfully.');
                    }
                } elseif ($notification->method == 'all')
                {
                    $mobileNumberString = $users->pluck('mobile')->filter()->unique()->implode(',');
                    $sms = ViewHelper::sendSms($mobileNumberString, html_entity_decode($notification->msg));

                    $data = [
                        'msg'  => $notification->msg,
                        'siteSetting'   => SiteSetting::first(),
                    ];
                    $emails = $users->pluck('email')->filter()->unique();
                    $errors = '';
                    foreach ($emails as $email)
                    {
//                        without queue
//                        try {
//                            Mail::send('backend.admin-views.send-notification.msg', $data, function ($message) use ($data, $email){
//                                $message->to($email, 'Like Wise Bd')->subject('Notification Message');
//                            });
//                        }  catch (\Exception $e) {
//                            // Handle any other errors
//                            $errors .= "Failed to send email to {$email}<br>";
//                            \Log::error("Failed to send email to {$email}: " . $e->getMessage());
//                        }

//                        with queue;
                        SendNotificationEmail::dispatch($email, $data);
                        ViewHelper::startQueueWorkManuallyByArtisanCommand();
                    }
                    if ($errors) {
                        Toastr::error($errors);
                    } else {
                        Toastr::success('Message sent successfully.');
                    }

                }
            } catch (\Exception $exception)
            {
//                Toastr::error($exception->getMessage());
                Toastr::error('Message sending faild. Please try again.');
                return back();
            }
            $notification->send_count = ++$notification->send_count;
            $notification->save();
            return  back();
        }
        Toastr::error('Notification sending failed. Please try again.');
        return back();
    }
}
