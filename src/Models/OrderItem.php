<?php

namespace Yab\Quazar\Models;

use Yab\Quarx\Models\QuarxModel;
use Yab\Quazar\Models\Order;
use Yab\Quazar\Models\Product;
use Yab\Quazar\Models\Variant;

class OrderItem extends QuarxModel
{
    public $table = 'order_items';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'order_id',
        'product_id',
        'transaction_id',
        'quantity',
        'variants',
        'was_refunded',
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
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the corresponding Refund
     *
     * @return Relationship
     */
    public function refund()
    {
        return $this->hasOne(Refund::class);
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

    /**
     * Get the variants of the product
     *
     * @return Attribute
     */
    public function getProductVariantsAttribute()
    {
        $itemVariants = [];
        $variants = json_decode($this->variants);

        if ($variants) {
            $variantModel = app(Variant::class);

            foreach ($variants as $variant) {
                $variantData = $variantModel->find($variant->variant);
                $itemVariants[$variantData->key] = $variantModel->rawValue($variant->value);
            }
        }

        return $itemVariants;
    }

    public function getAmountAttribute()
    {
        return $this->total * 100;
    }
}
