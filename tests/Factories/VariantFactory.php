<?php

/*
|--------------------------------------------------------------------------
| Product Variant Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Sitec\Commerce\Models\Variant::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'product_id' => 1,
        'key' => 'Size',
        'value' => 'small|medium|large(+2)[+2]',
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});
