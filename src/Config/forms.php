<?php

/*
|--------------------------------------------------------------------------
| Module Config
|--------------------------------------------------------------------------
*/

return [

    'blog' => [
        'title'       => [
            'type' => 'string',
        ],
        'url'       => [
            'type' => 'string',
        ],
        'tags'       => [
            'type' => 'string',
            'class' => 'tags'
        ],
        'entry'       => [
            'type' => 'text',
            'class' => 'redactor',
            'alt_name' => 'Content',
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published'
        ],
    ],

    'images' => [
        'location'       => [
            'type' => 'file',
            'alt_name' => 'File'
        ],
        'name'       => [
            'type' => 'string',
        ],
        'alt_tag'       => [
            'type' => 'string',
            'alt_name' => 'Alt Tag',
        ],
        'title_tag'       => [
            'type' => 'string',
            'alt_name' => 'Title Tag',
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published'
        ],
    ],

    'page' => [
        'title'       => [
            'type' => 'string',
        ],
        'url'       => [
            'type' => 'string',
        ],
        'entry'       => [
            'type' => 'text',
            'class' => 'redactor',
            'alt_name' => 'Content',
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published'
        ],
    ],

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

    'widget' => [
        'name'       => [
            'type' => 'string',
        ],
        'uuid'       => [
            'type' => 'string',
        ],
        'content'       => [
            'type' => 'text',
            'class' => 'redactor',
        ],
    ],

    'faqs' => [
        'question'       => [
            'type' => 'string',
        ],
        'answer'       => [
            'type' => 'text',
            'class' => 'redactor',
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published'
        ],
    ],

    'link' => [
        'name'       => [
            'type' => 'string',
        ],
        'external'       => [
            'type' => 'checkbox',
            'custom' => 'value="1"'
        ],
        'external_url' => [
            'type' => 'string',
            'alt_name' => 'Url'
        ],
        'page_id' => [
            'type' => 'select',
            'alt_name' => 'Page',
            'options' => PageService::getPagesAsOptions()
        ],
        'menu_id' => [
            'type' => 'hidden',
        ],
    ],

    'subscription' => [
        'name'       => [
            'type' => 'string',
        ],
        'url'       => [
            'type' => 'string',
        ],
        'price'       => [
            'type' => 'number',
        ],
        'provider_id'       => [
            'type' => 'string',
            'alt_name' => 'Provider ID',
        ],
        'interval'       => [
            'type' => 'select',
            'options' => [
                'Monthly' => 'monthly',
                'Weekly' => 'weekly',
                'Yearly' => 'yearly',
                'Semi-Annual' => 'semi-annual',
                'Quarterly' => 'quarterly',
            ]
        ],
        'trial'       => [
            'type' => 'number',
            'alt_name' => 'Trial (In Days)'
        ],
        'statement_desc'       => [
            'type' => 'string',
            'alt_name' => 'Statement Description'
        ],
        'description'       => [
            'type' => 'text',
            'alt_name' => 'Details',
            'class' => 'redactor'
        ],
        'hero_image' => [
            'type' => 'file',
            'alt_name' => 'Hero Image'
        ],
        'is_published' => [
            'type' => 'checkbox',
            'alt_name' => 'Published',
            'custom' => 'value="1"'
        ],
        'is_featured' => [
            'type' => 'checkbox',
            'alt_name' => 'Featured',
            'custom' => 'value="1"'
        ],
    ],

];