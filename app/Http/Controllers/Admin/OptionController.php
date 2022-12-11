<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailConfig;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function mailConfig(Request $request)
    {
        $request->validate([
            'mail_mailer'   => 'required | string',
            'mail_host'     => 'required | string',
            'mail_port'     => 'required | string',
            'mail_username' => 'required | string',
            'mail_password' => 'required | string',
            'mail_address'  => 'required | string',
            'mail_from'     => 'required | string',
        ]);
        try {
            MailConfig::findOrFail(1)->update([
                'mail_mailer'   => $request->mail_mailer,
                'mail_host'     => $request->mail_host,
                'mail_port'     => $request->mail_port,
                'mail_username' => $request->mail_username,
                'mail_password' => $request->mail_password,
                'mail_address'  => $request->mail_address,
                'mail_from'     => $request->mail_from,
            ]);
            $mailConfig = MailConfig::findOrFail(1);
            if ($mailConfig)
            {
                $path = base_path('.env');
                if (file_exists($path))
                {

                    file_put_contents($path, str_replace(
                        "MAIL_MAILER" . '=' . env("MAIL_MAILER"), "MAIL_MAILER" . '=' . $mailConfig->mail_mailer, file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        "MAIL_HOST" . '=' . env("MAIL_HOST"), "MAIL_HOST" . '=' . $mailConfig->mail_host, file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        "MAIL_PORT" . '=' . env("MAIL_PORT"), "MAIL_PORT" . '=' . $mailConfig->mail_port, file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        "MAIL_USERNAME" . '=' . env("MAIL_USERNAME"), "MAIL_USERNAME" . '=' . $mailConfig->mail_username, file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        "MAIL_PASSWORD" . '=' . env("MAIL_PASSWORD"), "MAIL_PASSWORD" . '=' . $mailConfig->mail_password, file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        "MAIL_FROM_ADDRESS" . '=' . env("MAIL_FROM_ADDRESS"), "MAIL_FROM_ADDRESS" . '=' . $mailConfig->mail_address, file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        "MAIL_FROM_NAME" . '=' . env("MAIL_FROM_NAME"), "MAIL_FROM_NAME" . '=' . '"' . $mailConfig->mail_from . '"', file_get_contents($path)
                    ));
                    // Artisan::call('optimize');
                }
            }
            return redirect()->back()->withSuccess('Mail Configuration Saved Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function sslConfig(Request $request)
    {
        $request->validate([
            'ssl_store_id'       => 'required | string',
            'ssl_store_password' => 'required | string',
        ]);
        try {
            Option::where('key', '=', 'ssl_store_id')->update([
                'value' => $request->ssl_store_id,
            ]);
            Option::where('key', '=', 'ssl_store_password')->update([
                'value' => $request->ssl_store_password,
            ]);
            $storeId       = Option::where('key', '=', 'ssl_store_id')->first();
            $storePassword = Option::where('key', '=', 'ssl_store_password')->first();
            $path          = base_path('.env');
            if (file_exists($path))
            {

                file_put_contents($path, str_replace(
                    "STORE_ID" . '=' . env("STORE_ID"), "STORE_ID" . '=' . $storeId->value, file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "STORE_PASSWORD" . '=' . env("STORE_PASSWORD"), "STORE_PASSWORD" . '=' . $storePassword->value, file_get_contents($path)
                ));
                // Artisan::call('optimize');
            }
            return redirect()->back()->withSuccess('SSLCommerz Configuration Saved Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
    public function amaarpayConfig(Request $request)
    {
        $request->validate([
            'amaarpay_store_id'      => 'required | string',
            'amaarpay_signature_key' => 'required | string',
        ]);
        try {
            Option::where('key', '=', 'amaarpay_store_id')->update([
                'value' => $request->amaarpay_store_id,
            ]);
            Option::where('key', '=', 'amaarpay_signature_key')->update([
                'value' => $request->amaarpay_signature_key,
            ]);
            return redirect()->back()->withSuccess('Amarpay Configuration Saved Successfully');
        }
        catch (\Exception$e)
        {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}