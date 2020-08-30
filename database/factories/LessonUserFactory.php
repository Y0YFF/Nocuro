<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LessonUser;
use Faker\Generator as Faker;

$factory->define(LessonUser::class, function (Faker $faker) {
    return [
        'lesson_id' => $faker->randomDigit,
        'course_id' => $faker->randomDigit,
        'user_id' => $faker->randomDigit,
     ];
});
