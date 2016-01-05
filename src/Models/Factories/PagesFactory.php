<?php

/*
|--------------------------------------------------------------------------
| Pages Factory
|--------------------------------------------------------------------------
*/

$factory->define(\Mlantz\Hadron\Models\Pages::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'title' => 'dumb',
        'url' => 'dumb',
        'seo_keywords' => 'dumb, dumber',
        'seo_description' => 'dumb is dumb',
        'entry' => $faker->paragraph().' '.$faker->paragraph(),
        'is_published' => 1,
        'template_id' => 1,
        'updated_at' => $faker->datetime(),
        'created_at' => $faker->datetime(),
    ];
});
