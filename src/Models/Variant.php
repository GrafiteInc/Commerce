<?php

namespace Quarx\Modules\Hadron\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{

    public $table = "product_variants";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "product_id",
        "key",
        "value",
    ];

    public static $rules = [
    ];

}
