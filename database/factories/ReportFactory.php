<?php

use Faker\Generator as Faker;

$factory->define(App\Report::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 10),
        'station_id' => $faker->numberBetween(1, 3),
        'type' => $faker->randomElement(['חסר משהו', 'לא נקי', 'יש תקלה', 'אחר']),
        'desc' => $faker->sentence(6),
        'status' => $faker->numberBetween(0, 1)
    ];
});
