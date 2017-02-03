<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;
use Yab\Quazar\Services\ProductService;

class Variant extends QuarxModel
{
    public $table = 'product_variants';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'product_id',
        'key',
        'value',
    ];

    public static $rules = [];

    public function getOptionsAttribute()
    {
        return app(ProductService::class)->variantOptions($this);
    }
}
