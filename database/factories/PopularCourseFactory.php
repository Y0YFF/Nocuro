<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PopularCourse;
use Faker\Generator as Faker;

$factory->define(PopularCourse::class, function (Faker $faker) {
    return [
        'course_id' => $faker->uuid,
    ];
});
