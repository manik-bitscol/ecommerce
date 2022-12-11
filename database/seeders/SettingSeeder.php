<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create([
            'title'           => 'This is Website Title',
            'logo'            => 'uploads/setting/logo.png',
            'favicon'         => 'uploads/setting/favicon.ico',
            'seo_title'       => 'Seo Title for this ecommerce website',
            'seo_meta'        => 'Ecommerce, EPEC Ecommerce',
            'seo_description' => 'Ecommerce, EPEC Ecommerce website for selling products',
            'address'         => 'House-33, Road-15, Sector-11, Uttara, Dhaka',
            'email'           => 'epec@gmail.com',
            'phone_1'         => '+8801858674565',
            'phone_2'         => '+8801858674565',
            'facebook'        => 'https://www.facebook.com/fb.bitscol',
            'whatsapp'        => 'https://www.facebook.com/fb.bitscol',
            'twitter'         => 'https://www.facebook.com/fb.bitscol',
            'instagram'       => 'https://www.facebook.com/fb.bitscol',
            'youtube'         => 'https://www.facebook.com/fb.bitscol',
        ]);
    }
}