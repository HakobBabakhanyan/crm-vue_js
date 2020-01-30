<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name' => 'US Dollar',
            'code' => 'USD',
            'rate' => 1,
            'status' => 1,
            'default' => 1,
        ]);
        DB::table('currencies')->insert([
            'name' => 'Euro',
            'code' => 'EUR',
            'rate' => 0.8,
            'status' => 1,
            'default' => 0,
        ]);
    }
}
