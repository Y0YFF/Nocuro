<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LinkedSocialAccount;
use Faker\Generator as Faker;

$factory->define(LinkedSocialAccount::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit,
        'provider_id' => strval($faker->randomDigit),
        'provider_name' => 'twitter',
    ];
});
