<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Item::class, function (Faker $faker) {
    return [
        'name'=>$faker->firstNameFemale,
        'purchase_price'=>$faker->randomNumber(2),
        'sale_price'=>$faker->randomNumber(3)
    ];
});
