<?php

/*
|--------------------------------------------------------------------------
| Subscriptions Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Mlantz\Hadron\Models\SubscriptionPlans::class, function (Faker\Generator $faker) {
    return [

        'id' => 1,
        'name' => 'cheap hosting',
        'url' => 'cheap-hosting',
        'price' => 9999,
        'provider_id' => 'cheap-package',
        'interval' => 'monthly',
        'trial' => 30,
        'statement_desc' => 'dumb is dumb',
        'description' => $faker->paragraph().' '.$faker->paragraph(),
        'is_published' => 1,
        'is_featured' => 1,
        'hero_image' => '',
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),

    ];
});
