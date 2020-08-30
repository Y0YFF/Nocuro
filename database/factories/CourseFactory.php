<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'link' => $faker->url,
        'bookmark_count' => $faker->randomDigit,
    ];
});
