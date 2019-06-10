<?php

/*
|--------------------------------------------------------------------------
| Order Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Sitec\Commerce\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'uuid' => 'foo-bar-foo-bar',
        'user_id' => 1,
        'transaction_id' => 999,
        'details' => $faker->paragraph().' '.$faker->paragraph(),
        'shipping_address' => json_encode([
            'address' => '21 Iceboat Terr',
            'city' => 'Toronto',
            'country' => 'Canada',
            'state' => 'Ontario',
        ]),
        'is_shipped' => false,
        'tracking_number' => null,
        'notes' => 'This is a test order duh',
        'status' => 'pending',
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});
