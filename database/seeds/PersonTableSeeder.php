<?php

use Illuminate\Database\Seeder;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Person::class, 50)->create()
            ->each(function ($person) {
//                $person->customers()->save(factory(App\Models\Customer::class)->make());
            });;
    }
}
