<?php

use Faker\Factory as Faker;

$factory->define(App\Author::class, function () {
    $faker = Faker::create('ru_RU');
    return [
        'name' => $faker->name
    ];
});
