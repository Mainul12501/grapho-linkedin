<?php

namespace App\Http\Controllers\Backend\SiteControllers;

use App\Helpers\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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

    public function updateVendorCredentials(Request $request)
    {
        try {
            //        alfa net
            if ($request->filled('SMS_ALPHA_SMS_API_KEY')) {
                $this->updateEnv('SMS_ALPHA_SMS_API_KEY', $request->SMS_ALPHA_SMS_API_KEY);
            }
//        google auth
            if ($request->filled('GOOGLE_CLIENT_ID')) {
                $this->updateEnv('GOOGLE_CLIENT_ID', $request->GOOGLE_CLIENT_ID);
            }
            if ($request->filled('GOOGLE_CLIENT_SECRET')) {
                $this->updateEnv('GOOGLE_CLIENT_SECRET', $request->GOOGLE_CLIENT_SECRET);
            }
            if ($request->filled('GOOGLE_REDIRECT')) {
                $this->updateEnv('GOOGLE_REDIRECT', $request->GOOGLE_REDIRECT);
            }
//        ssl commerze
            if ($request->filled('SSLC_STORE_ID')) {
                $this->updateEnv('SSLC_STORE_ID', $request->SSLC_STORE_ID);
            }
            if ($request->filled('SSLC_STORE_PASSWORD')) {
                $this->updateEnv('SSLC_STORE_PASSWORD', $request->SSLC_STORE_PASSWORD);
            }
            if ($request->filled('SSLC_TESTMODE')) {
                $this->updateEnv('SSLC_TESTMODE', $request->SSLC_TESTMODE);
            }
//        pusher
            if ($request->filled('PUSHER_APP_KEY')) {
                $this->updateEnv('PUSHER_APP_KEY', $request->PUSHER_APP_KEY);
            }
            if ($request->filled('PUSHER_APP_SECRET')) {
                $this->updateEnv('PUSHER_APP_SECRET', $request->PUSHER_APP_SECRET);
            }
            if ($request->filled('PUSHER_APP_ID')) {
                $this->updateEnv('PUSHER_APP_ID', $request->PUSHER_APP_ID);
            }
            if ($request->filled('PUSHER_APP_CLUSTER')) {
                $this->updateEnv('PUSHER_APP_CLUSTER', $request->PUSHER_APP_CLUSTER);
            }
//        twilo
            if ($request->filled('TWILIO_ACCOUNT_SID')) {
                $this->updateEnv('TWILIO_ACCOUNT_SID', $request->TWILIO_ACCOUNT_SID);
            }
            if ($request->filled('TWILIO_API_KEY')) {
                $this->updateEnv('TWILIO_API_KEY', $request->TWILIO_API_KEY);
            }
            if ($request->filled('TWILIO_API_SECRET')) {
                $this->updateEnv('TWILIO_API_SECRET', $request->TWILIO_API_SECRET);
            }
        } catch (\Exception $exception)
        {
            return $exception->getMessage();
        }

        if ($request->ajax())
        {
            return response()->json([
                'status' => 'success',
                'msg'   => 'Credentials updated successfully',
            ]);
        }

        Toastr::success('Credentials updated successfully.');
        return back();
    }

    private function updateEnv($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            // Escape special characters in value
            $value = str_replace('\\', '\\\\', $value);
            $value = str_replace('"', '\"', $value);

            $envContent = file_get_contents($path);

            // Check if key exists
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                // Update existing key
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}=\"{$value}\"",
                    $envContent
                );
            } else {
                // Add new key
                $envContent .= "\n{$key}=\"{$value}\"";
            }

            file_put_contents($path, $envContent);

            // Clear config cache
            Artisan::call('config:clear');
        }
    }
}
