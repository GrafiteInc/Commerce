<?php

/*
|--------------------------------------------------------------------------
| Product Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Sitec\Commerce\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'name' => 'dumb',
        'url' => 'dumb',
        'code' => 'a98s7d9',
        'price' => 9999,
        'weight' => 0,
        'width' => '9',
        'height' => '11',
        'depth' => '8',
        'discount' => 0,
        'discount_type' => '',
        'stock' => 1,
        'is_available' => 1,
        'is_published' => 1,
        'is_featured' => 0,
        'is_download' => 1,
        'file' => '',
        'hero_image' => '',
        'seo_keywords' => 'dumb is dumb',
        'seo_description' => 'dumb is dumb',
        'details' => $faker->paragraph().' '.$faker->paragraph(),
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});
