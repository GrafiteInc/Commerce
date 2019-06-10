<?php

namespace SierraTecnologia\Commerce\Services\Concerns;

use SierraTecnologia\Commerce\Models\Favorite;
use SierraTecnologia\Commerce\Models\Product;

trait hasFavorites
{
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * The products that the user has favourited
     *
     * @return Collection
     */
    public function favouriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id');
    }
}
