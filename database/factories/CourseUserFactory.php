<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CourseUser;
use Faker\Generator as Faker;

$factory->define(CourseUser::class, function (Faker $faker) {
    return [
        'course_id' => $faker->uuid,
        'user_id' => $faker->randomDigit,
        'checked_count' => $faker->randomDigit,
    ];
});
