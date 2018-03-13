<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'station_id' => $faker->numberBetween(1, 3),
        'user_id' => $faker->numberBetween(1, 10),
        'amount' => $faker->randomDigit()
    ];
});
