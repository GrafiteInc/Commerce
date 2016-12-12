<?php

/*
|--------------------------------------------------------------------------
| Hadron Config
|--------------------------------------------------------------------------
*/

return [

    'download' => [
        'file' => [
            'type' => 'file',
            'alt_name' => 'Product File',
        ],
    ],

    'discounts' => [
        'discount' => [
            'type' => 'number',
            'alt_name' => 'Discount (&dollar; or %)',
        ],
        'discount_type' => [
            'type' => 'select',
            'options' => [
                'Dollars (&dollar;)' => 'cents',
                'Percentage (%)' => 'percentage',
            ],
        ],
        'discount_start_date' => [
            'type' => 'date',
        ],
        'discount_end_date' => [
            'type' => 'date',
        ],
    ],

    'details' => [
        'name' => [
            'type' => 'string',
        ],
        'url' => [
            'type' => 'string',
        ],
        'seo_keywords' => [
            'type' => 'string',
            'alt_name' => 'SEO Keywords',
        ],
        'seo_description' => [
            'type' => 'text',
            'alt_name' => 'SEO Description',
        ],
        'code' => [
            'type' => 'string',
            'alt_name' => 'SKU',
        ],
        'price' => [
            'type' => 'float',
            'custom' => 'min="0"',
            'alt_name' => 'Price (&dollar;)',
        ],
        'hero_image' => [
            'type' => 'file',
            'alt_name' => 'Hero Image',
        ],
        'details' => [
            'type' => 'text',
            'class' => 'redactor',
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published',
        ],
        'is_available' => [
            'type' => 'checkbox',
            'alt_name' => 'Available',
        ],
        'is_download' => [
            'type' => 'checkbox',
            'alt_name' => 'Is Downloaded',
        ],
        'is_featured' => [
            'type' => 'checkbox',
            'alt_name' => 'Is Featured',
        ],
    ],

    'dimensions' => [
        'weight' => [
            'type' => 'string',
        ],
        'width' => [
            'type' => 'string',
        ],
        'height' => [
            'type' => 'string',
        ],
        'depth' => [
            'type' => 'string',
        ],
        'stock' => [
            'type' => 'number',
        ],
    ],

'plans' => [
        'name' => [
            'type' => 'string',
        ],
        'amount' => [
            'type' => 'number',
        ],
        'interval' => [
            'type' => 'select',
            'options' => [
                'Weekly' => 'week',
                'Monthly' => 'month',
                'Yearly' => 'year',
            ],
        ],
        'currency' => [
            'type' => 'select',
            'options' => [
                'CAD' => 'cad',
                'USD' => 'usd',
                'EUR' => 'eur',
                'GBP' => 'gbp',
            ],
        ],
        'trial_days' => [
            'type' => 'number',
            'alt_name' => 'Trial Days',
        ],
        'stripe_name' => [
            'type' => 'string',
        ],
        'subscription_name' => [
            'type' => 'string',
        ],
        'descriptor' => [
            'type' => 'textarea',
        ],
        'description' => [
            'type' => 'textarea',
        ],
    ],

    'plans-edit' => [
        'name' => [
            'type' => 'string',
        ],
        'descriptor' => [
            'alt_name' => 'Descriptor (on Credit Card)',
            'type' => 'string',
        ],
        'description' => [
            'type' => 'textarea',
        ],
    ],

];
