<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TeacherCV;
use Faker\Generator as Faker;

$factory->define(TeacherCV::class, function (Faker $faker) {
    return [
        'cv' => $faker->text()
    ];
});
