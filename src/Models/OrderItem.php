<?php

namespace Yab\Quazar\Models;

use Yab\Quazar\Models\Orders;
use Yab\Quazar\Models\Product;
use Yab\Quarx\Models\QuarxModel;

class OrderItem extends QuarxModel
{
    public $table = 'order_items';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'status',
    ];

    public static $rules = [];

    /**
     * Get the corresponding Order
     *
     * @return Relationship
     */
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    /**
     * Get the corresponding Product
     *
     * @return Relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
