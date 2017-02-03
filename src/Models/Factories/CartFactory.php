<?php

/*
|--------------------------------------------------------------------------
| Cart Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Yab\Quazar\Models\Cart::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'customer_id' => 1,
        'entity_id' => 1,
        'entity_type' => 'product',
        'product_variants' => '',
        'address' => '',
        'quantity' => 1,
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});
