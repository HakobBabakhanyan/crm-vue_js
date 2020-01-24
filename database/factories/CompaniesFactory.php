<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Companies;
use Faker\Generator as Faker;

$factory->define(Companies::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'type' => 'test',
    ];
});
