<?php

use Faker\Factory as Faker;

$factory->define(App\Book::class, function () {
    $faker = Faker::create('ru_RU');
    return [
        'title' => $faker->realText(20),
        'about' => $faker->realText(420)
    ];
});
