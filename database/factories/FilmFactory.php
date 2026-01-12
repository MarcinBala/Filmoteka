<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Film;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Film::class, function (Faker $faker) {
    return [
        'title' => Str::random(10),
        'original_title' => Str::random(10),
        'release' => Carbon::now()->subDays(30),
        'length' => 100,
        'image'=>'uploads/00SNaQo7.jpg'
    ];
});
