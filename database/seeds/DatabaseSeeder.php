<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminTableSeeder::class);
         $this->call(CompanyTableSeeder::class);
         $this->call(PersonTableSeeder::class);
         $this->call(ItemTableSeeder::class);
         $this->call(CurrencyTableSeeder::class);
         $this->call(TaxTableSeeder::class);
    }
}
