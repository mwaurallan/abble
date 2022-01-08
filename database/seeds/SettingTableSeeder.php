<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('settings')
            ->delete(); // deleting old records.
        DB::table('settings')
            ->truncate(); // Truncating old records.

        $faker = Faker::create();
        \App\Models\Setting::create([
            'main_name' => 'CrossCut HRIS',
            'email' => 'elizabeth@crosscutsolutions.co.ke',
            'name' => 'Administrator',
            'contact' => '0725614645',
            'address' => 'Westlands Arcade Rm 216',
            'admin_theme' => 'blue',
            'currency' => 'KES',
            'currency_symbol' => 'KES',
            'status' => 'active',
            'verified' => true,
            'purchase_code' => 'sdsad',
        ]);
    }
}
