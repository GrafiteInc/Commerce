<?php

namespace Sitec\Commerce\Models;

use Sitec\Cms\Models\CmsModel;

class Cart extends CmsModel
{
    public $table = 'cart';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
        'address',
        'product_variants',
        'quantity',
    ];

    public static $rules = [];
}
