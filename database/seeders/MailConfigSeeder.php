<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\MailConfig::create([
            'mail_mailer'   => 'smtp',
            'mail_host'     => 'smtp.gmail.com',
            'mail_port'     => '465',
            'mail_username' => 'username',
            'mail_password' => 'password',
            'mail_address'  => 'epec@gmail.com',
            'mail_from'     => 'EPEC Ecomerce',
        ]);
    }
}