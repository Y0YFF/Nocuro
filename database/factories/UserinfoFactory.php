<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Userinfo;
use Faker\Generator as Faker;

$factory->define(Userinfo::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'completed_course_count' => $faker->randomDigit,
    ];
});
