<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Model\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
