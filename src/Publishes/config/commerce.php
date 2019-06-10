<?php

/*
 * --------------------------------------------------------------------------
 * Commerce config
 * --------------------------------------------------------------------------
*/

return [

    'name' => 'SierraTecnologia Commerce',
    'currency' => env('CURRENCY', 'usd'),
    'taxes_include_shipping' => true,
    'store_url_prefix' => 'store',
    'currencies' => [
        'AUD' => 'aud',
        'CAD' => 'cad',
        'USD' => 'usd',
        'GBP' => 'gbp',
        'DKK' => 'dkk',
        'NOK' => 'nok',
        'SEK' => 'sek',
    ],

    /*
     * --------------------------------------------------------------------------
     * Do you want to offer subscriptions?
     * --------------------------------------------------------------------------
    */

    'subscriptions' => false,

    /*
     * --------------------------------------------------------------------------
     * Forms
     * --------------------------------------------------------------------------
    */

    'forms' => [
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
            'identity' => [
                'name' => [
                    'type' => 'string',
                ],
                'url' => [
                    'type' => 'string',
                ],
            ],
            'price' => [
                'code' => [
                    'type' => 'string',
                    'alt_name' => 'SKU',
                ],
                'price' => [
                    'type' => 'float',
                    'custom' => 'min="0"',
                    'alt_name' => 'Price (&dollar;)',
                ],
            ],
            'content' => [
                'details' => [
                    'type' => 'text',
                    'class' => 'redactor',
                ],
                'hero_image' => [
                    'type' => 'file',
                    'alt_name' => 'Hero Image',
                ],
            ],
            'seo' => [
                'seo_keywords' => [
                    'type' => 'string',
                    'class' => 'tags',
                    'alt_name' => 'SEO Keywords',
                ],
                'seo_description' => [
                    'type' => 'text',
                    'alt_name' => 'SEO Description',
                ],
            ],
            'options' => [
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
                'alt_name' => 'Amount (&cent;)',
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
                'options' => config('commerce.currencies', [
                    'AUD' => 'aud',
                    'CAD' => 'cad',
                    'USD' => 'usd',
                    'GBP' => 'gbp',
                    'DKK' => 'dkk',
                    'NOK' => 'nok',
                    'SEK' => 'sek',
                ]),
            ],
            'trial_days' => [
                'type' => 'number',
                'alt_name' => 'Trial Days',
            ],
            'descriptor' => [
                'type' => 'string',
                'alt_name' => 'Credit Card Descriptor',
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
            'is_featured' => [
                'type' => 'checkbox',
                'alt_name' => 'Is Featured',
            ],
        ],

        'coupons' => [
            'code' => [
                'type' => 'string',
                'alt_name' => 'Coupon Code',
                'placeholder' => 'Coupon Code',
            ],
            'discount_type' => [
                'type' => 'select',
                'options' => [
                    'Dollar' => 'dollar',
                    'Percentage' => 'percentage',
                ]
            ],
            'amount' => [
                'type' => 'number',
                'alt_name' => 'Amount (&cent; or %)',
            ],
            'limit' => [
                'type' => 'number',
            ],
            'for_subscriptions' => [
                'type' => 'checkbox',
                'alt_name' => 'For Subscriptions',
            ],
            'start_date' => [
                'type' => 'date',
            ],
            'end_date' => [
                'type' => 'date',
            ],
        ],
    ],

];
