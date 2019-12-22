<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\DownloadRecord::class, function (Faker $faker) {
    $now = now();
    return [
        'status' => 'pending',
        'url' => $faker->imageUrl(),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
