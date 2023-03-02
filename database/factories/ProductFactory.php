<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
		'status'=>$faker->numberBetween(0,1),
		'key'=>$faker->randomNumber(),
		'barcode'=>$faker->ean13,
		'name'=>$faker->word,
		'description'=>$faker->realText(random_int(10, 25)),
		'cost'=>$faker->randomFloat(2,10,999),
		'retail'=>$faker->randomFloat(2,10,999),
		'wholesale'=>$faker->randomFloat(2,10,999),
		'image'=>$faker->imageUrl(600,338),
		'proveedor_id'=>$faker->numberBetween(1,20),
		'category_id'=>$faker->numberBetween(1,10),
    ];
});
