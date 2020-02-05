<?php

use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->insert([
            'name' => 'test',
            'rate' => 20,
            'type' => 1,
            'status' => 1,
        ]);
    }
}
