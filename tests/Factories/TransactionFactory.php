<?php

/*
|--------------------------------------------------------------------------
| Transaction Factory
|--------------------------------------------------------------------------
*/

$factory->define(\SierraTecnologia\Commerce\Models\Transaction::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'uuid' => 'foo-bar-foo-bar',
        'user_id' => 1,
        'provider' => 'stripe',
        'state' => 'success',
        'subtotal' => 99.99,
        'tax' => 0,
        'total' => 109.99,
        'shipping' => 10.00,
        'refund_date' => null,
        'refund_requested' => false,
        'provider_id' => 'foo-bar-999',
        'provider_date' => 20160930,
        'provider_dispute' => null,
        'notes' => null,
        'cart' => json_encode([[
            'price' => 19.00,
            'quantity' => 1,
            'name' => 'StarWars',
        ]]),
        'response' => json_encode(['message' => 'success']),
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});
