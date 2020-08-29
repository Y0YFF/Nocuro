<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bookmark;
use Faker\Generator as Faker;

$factory->define(Bookmark::class, function (Faker $faker) {
    return [
        'course_id' => $faker->randomDigit,
        'user_id' => $faker->randomDigit,
    ];
});
