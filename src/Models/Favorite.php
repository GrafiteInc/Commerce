<?php

namespace Sitec\Commerce\Models;

use Sitec\Cms\Models\CmsModel;
use Sitec\Commerce\Models\Product;

class Favorite extends CmsModel
{
    public $table = 'favorites';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'product_id',
        'user_id',
    ];

    /**
     * Get the corresponding Product
     *
     * @return Relationship
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
