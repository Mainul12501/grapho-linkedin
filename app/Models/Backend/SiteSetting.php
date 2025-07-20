<?php

namespace App\Models\Backend;

use App\Http\Controllers\Backend\SiteControllers\SiteSettingsController;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'site_title',
        'site_description',
        'logo',
        'site_icon',
        'favicon',
        'meta_header',
        'meta_footer',
        'meta_title',
        'meta_description',
        'banner',
        'email',
        'mobile',
        'fb',
        'x_link',
        'youtube',
        'insta',
        'tiktalk',
        'apk_link',
        'ios_link',
        'apk_latest_version',
        'ios_latest_version',
        'office_address',
        'country',
        'country_code',
        'site_name',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'site_settings';

    public static function createOrUpdateSiteSetting($request)
    {
        $siteSetting = SiteSetting::first();
        if (!$siteSetting)
        {
            $siteSetting    = new SiteSetting();
        }
        $siteSetting->site_title    = $request->site_title;
        $siteSetting->site_description  = $request->site_description;
        $siteSetting->logo  = imageUpload($request->file('logo'), 'site-setting', 'logo', 300, 300, $siteSetting->logo ?? null);
        $siteSetting->site_icon = imageUpload($request->file('site_icon'), 'site-setting', 'site_icon', 50, 50, $siteSetting->site_icon ?? null);
        $siteSetting->favicon   = imageUpload($request->file('favicon'), 'site-setting', 'favicon', 16, 16, $siteSetting->favicon ?? null);
        $siteSetting->meta_header   = $request->meta_header;
        $siteSetting->meta_footer   = $request->meta_footer;
        $siteSetting->meta_title    = $request->meta_title;
        $siteSetting->meta_description  = $request->meta_description;
        $siteSetting->banner    = imageUpload($request->file('banner'), 'site-setting', 'banner', 600, 300, $siteSetting->banner ?? null);;
        $siteSetting->email = $request->email;
        $siteSetting->mobile    = $request->mobile;
        $siteSetting->fb    = $request->fb;
        $siteSetting->x_link    = $request->x_link;
        $siteSetting->youtube   = $request->youtube;
        $siteSetting->insta = $request->insta;
        $siteSetting->tiktalk   = $request->tiktalk;
        $siteSetting->apk_link  = $request->apk_link;
        $siteSetting->ios_link  = $request->ios_link;
        $siteSetting->apk_latest_version    = $request->apk_latest_version;
        $siteSetting->ios_latest_version    = $request->ios_latest_version;
        $siteSetting->office_address    = $request->office_address;
        $siteSetting->country   = $request->country;
        $siteSetting->country_code  = $request->country_code;
        $siteSetting->site_name = $request->site_name;
        $siteSetting->save();
        return $siteSetting;
    }
}
