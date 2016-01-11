<?php

/*
|--------------------------------------------------------------------------
| Hadron Config
|--------------------------------------------------------------------------
*/

return [

    'product' => [
        'name' => [
            'type' => 'string',
        ],
        'url' => [
            'type' => 'string',
        ],
        'seo_keywords' => [
            'type' => 'string',
            'alt_name' => 'SEO Keywords'
        ],
        'seo_description' => [
            'type' => 'string',
            'alt_name' => 'SEO Description'
        ],
        'code'       => [
            'type' => 'string',
            'alt_name' => 'SKU',
        ],
        'price'       => [
            'type' => 'number',
            'alt_name' => 'Price (&cent;)'
        ],
        'weight'       => [
            'type' => 'string',
        ],
        'width'       => [
            'type' => 'string',
        ],
        'height'       => [
            'type' => 'string',
        ],
        'depth'       => [
            'type' => 'string',
        ],
        'stock'       => [
            'type' => 'number',
        ],
        'discount'       => [
            'type' => 'number',
            'alt_name' => 'Discount (&cent; or %)'
        ],
        'discount_type'       => [
            'type' => 'select',
            'options' => [
                'Percentage (%)' => 'percentage',
                'Cents (&cent;)' => 'cents',
            ]
        ],
        'discount_start_date' => [
            'type' => 'date'
        ],
        'discount_end_date' => [
            'type' => 'date'
        ],
        'hero_image' => [
            'type' => 'file',
            'alt_name' => 'Hero Image'
        ],
        'details'       => [
            'type' => 'text',
            'class' => 'redactor',
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published'
        ],
        'is_available' => [
            'type' => 'checkbox',
            'alt_name' => 'Available'
        ],
        'is_download' => [
            'type' => 'checkbox',
            'alt_name' => 'Is Downloaded'
        ],
        'is_subscription' => [
            'type' => 'checkbox',
            'alt_name' => 'Is Subscription'
        ],
        'has_interations' => [
            'type' => 'checkbox',
            'alt_name' => 'Has Interations'
        ],
        'is_featured' => [
            'type' => 'checkbox',
            'alt_name' => 'Is Featured'
        ],
        'file' => [
            'type' => 'file',
            'alt_name' => 'Product File'
        ],
    ],

];