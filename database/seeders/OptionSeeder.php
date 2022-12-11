<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Option::create([
            'key'   => 'ssl_store_id',
            'value' => 'abcec6347aa472d0b5',
        ]);
        \App\Models\Option::create([
            'key'   => 'ssl_store_password',
            'value' => 'abcec6347aa472d0b5@ssl',
        ]);
        \App\Models\Option::create([
            'key'   => 'aamaypay_store_id',
            'value' => 'aamarpaytest',
        ]);
        \App\Models\Option::create([
            'key'   => 'aamaypay_signature_key',
            'value' => 'dbb74894e82415a2f7ff0ec3a97e4183',
        ]);

        \App\Models\Option::create([
            'key'   => 'order_note',
            'value' => 'Order Note From Saller',
        ]);

    }
}