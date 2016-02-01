<?php

namespace Yab\Hadron\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    public $table = "cart";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
        'address',
        'product_variants',
        'quantity',
    ];

    public static $rules = [

    ];

}
