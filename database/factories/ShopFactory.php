<?php

use Faker\Generator as Faker;

$factory->define(App\Shop::class, function (Faker $faker) {
    return [
        'status'=> $faker->numberBetween(0,1),
		'name'=> $faker->word,
		'description'=> $faker->realText(random_int(10, 25)),
		'image'=> $faker->imageUrl(600,338),
    ];
});
