<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;

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
}
