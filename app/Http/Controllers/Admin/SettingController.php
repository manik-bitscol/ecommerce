<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailConfig;
use App\Models\Option;
use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings              = Setting::findOrFail(1);
        $mailConfig            = MailConfig::first();
        $sslStoreId            = Option::where('key', '=', 'ssl_store_id')->first();
        $sslStorePassword      = Option::where('key', '=', 'ssl_store_password')->first();
        $amaarypayStoreId      = Option::where('key', '=', 'aamaypay_store_id')->first();
        $amaarpaySingnatureKey = Option::where('key', '=', 'aamaypay_signature_key')->first();
        $orderNote             = Option::where('key', '=', 'order_note')->first();
        return view('admin.setting.index', compact('settings', 'sslStoreId', 'sslStorePassword', 'amaarypayStoreId', 'amaarpaySingnatureKey', 'orderNote', 'mailConfig'));
    }

    public function titleUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'title' => $request->title,
            ]);
            return redirect()->back()->withSuccess('Title Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function addressUpdate(Request $request)
    {

        $request->validate([
            'address' => 'required | min: 2 | string',
        ]);
        try {
            Setting::findOrFail(1)->update([
                'address' => $request->address,
            ]);
            return redirect()->back()->withSuccess('Office Address Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function logoUpdate(Request $request)
    {
        $request->validate([
            'logo' => 'required | image ',
        ]);
        try {
            if ($request->hasFile('logo'))
            {
                if (file_exists($request->old_logo))
                {
                    unlink($request->old_logo);
                }
                $logo     = $request->file('logo');
                $logoName = uniqid() . time() . '.' . $logo->extension();
                Image::make($logo)->resize(200, 60)->save('uploads/setting/' . $logoName);
                $logUrl = 'uploads/setting/' . $logoName;
                Setting::findOrfail(1)->update([
                    'logo' => $logUrl,
                ]);
            }
            return redirect()->back()->withSuccess('Logo Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function faviconUpdate(Request $request)
    {
        $request->validate([
            'favicon' => 'required | file ',
        ]);
        try {
            if ($request->hasFile('favicon'))
            {
                if (file_exists($request->old_favicon))
                {
                    unlink($request->old_favicon);
                }
                $favicon     = $request->file('favicon');
                $faviconName = uniqid() . time() . '.' . $favicon->extension();
                Image::make($favicon)->resize(32, 32)->save('uploads/setting/' . $faviconName);
                $url = 'uploads/setting/' . $faviconName;
                Setting::findOrfail(1)->update([
                    'favicon' => $url,
                ]);
            }
            return redirect()->back()->withSuccess('Favicon Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function seoTitleUpdate(Request $request)
    {
        $request->validate([
            'seo_title' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'seo_title' => $request->seo_title,
            ]);
            return redirect()->back()->withSuccess('SEO Title Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function seoMetaUpdate(Request $request)
    {
        $request->validate([
            'seo_meta' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'seo_meta' => $request->seo_meta,
            ]);
            return redirect()->back()->withSuccess('SEO Keywords Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function seoDescUpdate(Request $request)
    {
        $request->validate([
            'seo_description' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'seo_description' => $request->seo_description,
            ]);
            return redirect()->back()->withSuccess('SEO Description Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function phoneOne(Request $request)
    {
        $request->validate([
            'phone_1' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'phone_1' => $request->phone_1,
            ]);
            return redirect()->back()->withSuccess('Phone Number 1 Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function phoneTwo(Request $request)
    {
        $request->validate([
            'phone_2' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'phone_2' => $request->phone_2,
            ]);
            return redirect()->back()->withSuccess('Phone Number 2 Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function email(Request $request)
    {
        $request->validate([
            'email' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'email' => $request->email,
            ]);
            return redirect()->back()->withSuccess('Email Address Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function facebook(Request $request)
    {
        $request->validate([
            'facebook' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'facebook' => $request->facebook,
            ]);
            return redirect()->back()->withSuccess('Facebook Account Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function whatsapp(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'whatsapp' => $request->whatsapp,
            ]);
            return redirect()->back()->withSuccess('Whats App Account Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function twitter(Request $request)
    {
        $request->validate([
            'twitter' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'twitter' => $request->twitter,
            ]);
            return redirect()->back()->withSuccess('Twitter Account Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function instagram(Request $request)
    {
        $request->validate([
            'instagram' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'instagram' => $request->instagram,
            ]);
            return redirect()->back()->withSuccess('Instagram Account Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function youtube(Request $request)
    {
        $request->validate([
            'youtube' => 'required | string | min:2 ',
        ]);

        try {
            Setting::findOrFail(1)->update([
                'youtube' => $request->youtube,
            ]);
            return redirect()->back()->withSuccess('Youtube Account Updated Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }

}