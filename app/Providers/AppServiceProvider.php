<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $setting = Setting::findOrFail(1);
        View::share('setting', $setting);
        $cateroires = Category::orderBy('category_name_en', 'ASC')->get();
        View::share('categories', $cateroires);
        $subCategories = SubCategory::orderBy('subcategory_name_en', 'ASC')->get();
        View::share('subCategories', $subCategories);
        $subSubCategories = SubSubCategory::orderBy('subsubcategory_name_en', 'ASC')->get();
        View::share('subSubCategories', $subSubCategories);
        // $mailConfig = MailConfig::first();
        // if ($mailConfig)
        // {
        //     $data = [
        //         'mail_mailer'   => $mailConfig->mail_mailer,
        //         'mail_host'     => $mailConfig->mail_host,
        //         'mail_port'     => $mailConfig->mail_port,
        //         'mail_username' => $mailConfig->mail_username,
        //         'mail_password' => $mailConfig->mail_password,
        //         'mail_address'  => $mailConfig->mail_address,
        //         'mail_from'     => $mailConfig->mail_from,
        //     ];
        //     Config::set('mail', $data);
        // }

    }
}