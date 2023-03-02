<?php

use Faker\Generator as Faker;

$factory->define(App\Proveedor::class, function (Faker $faker) {
    return [      
		'shop_id'=>$faker->numberBetween(1,2),
		'status'=>$faker->numberBetween(0,1),
		'description'=>$faker->realText(random_int(10,25)),
		'name'=>$faker->name(),
		'address'=>$faker->address,
		'phone'=>$faker->tollFreePhoneNumber,
		'email'=>$faker->email,
		'commentary'=>$faker->sentence(5),
		'image'=>$faker->imageUrl(600,338),
    ];
});
