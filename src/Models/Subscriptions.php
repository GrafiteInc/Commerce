<?php

namespace Yab\Hadron\Models;

use Yab\Hadron\Models\Transactions;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{

    public $table = "subscriptions";

    public $primaryKey = "id";

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'available_shipments',
        'status',
    ];

    public static $rules = [

    ];

}
