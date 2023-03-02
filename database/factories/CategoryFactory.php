<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [      
		'status'=> $faker->numberBetween(0,1),
		'name'=> $faker->sentence($nbWords = 4),
		'description'=> $faker->realText(random_int(10, 25)),
		'image'=> $faker->imageUrl(600,338),
		'root'=> $faker->numberBetween(0,8),
		'shop_id'=>$faker->numberBetween(1,2),
    ];
});
