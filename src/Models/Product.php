<?php

namespace Yab\Hadron\Models;

use Eloquent;

class Product extends Eloquent
{
    public $table = "products";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "name",
        "url",
        "code",
        "price",
        "weight",
        "width",
        "height",
        "discount",
        "notification",
        "discount_type",
        "stock",
        "details",
        "hero_image",
        "is_available",
        "is_published",
        "is_download",
        "is_featured",
        "is_subscription",
        "has_iterations",
        "file",
        "seo_description",
        "seo_keywords"
    ];

    public static $rules = [
        'name' => ['required'],
        'price' => ['required'],
        'stock' => ['required'],
    ];

    public function price()
    {
        return round($this->price/100, 2);
    }

}
