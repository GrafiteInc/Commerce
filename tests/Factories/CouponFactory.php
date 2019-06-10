<?php

/*
|--------------------------------------------------------------------------
| Coupon Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Sitec\Commerce\Models\Coupon::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
        'start_date' => $faker->datetime(),
        'end_date' => $faker->datetime(),
        'code' => 'coupon-A',
        'currency' => 'usd',
        'discount_type' => 'dollar',
        'amount' => 5,
        'limit' => 1,
        'stripe_id' => 'coupon-A',
    ];
});
