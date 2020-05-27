<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserCdu;
use Faker\Generator as Faker;

$factory->define(UserCdu::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'pic' => "default.png",
        'code' => $faker->randomNumber(5),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->randomNumber(10),
        'active' => $faker->randomElement(['0', '1'])
    ];
});
