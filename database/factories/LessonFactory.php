<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'course_id' => $faker->randomDigit,
        'title' => $faker->sentence,
        'link' => $faker->url,
    ];
});
