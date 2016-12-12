<?php

namespace Quarx\Modules\Hadron\Models;

use Eloquent;

class CustomerProfile extends Eloquent
{
    public $table = "customer_profiles";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        "user_id",
        "stripe_id",
        "card_brand",
        "card_last_four",
        "shipping_address",
        "billing_address",
    ];

    public static $rules = [
    ];

}
