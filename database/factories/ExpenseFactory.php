<?php

use App\Expense;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Expense::class, function (Faker $faker) {
    return [
        'sum' => $faker->randomFloat(2, 1, 8 ),
        'date' => $faker->dateTimeBetween('2018-11-01', '2018-11-30'),
        'category_id' => $faker->numberBetween($min = 1, $max = 5),
        'user_id' => 1,
    ];
});
