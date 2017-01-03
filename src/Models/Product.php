<?php

namespace Quarx\Modules\Hadron\Models;

use Yab\Quarx\Models\QuarxModel;

class Product extends QuarxModel
{
    public $table = 'products';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'name',
        'url',
        'code',
        'price',
        'weight',
        'width',
        'height',
        'discount',
        'notification',
        'discount_type',
        'stock',
        'details',
        'hero_image',
        'is_available',
        'is_published',
        'is_download',
        'is_featured',
        'has_iterations',
        'file',
        'seo_description',
        'seo_keywords',
    ];

    public static $rules = [
        'name' => [
            'required',
        ],
        'price' => [
            'required',
        ],
    ];

    public function getPriceAttribute($value)
    {
        return round($value, 2) * 0.01;
    }
}
