<?php

namespace Sitec\Commerce\Repositories;

use Carbon\Carbon;
use Sitec\Commerce\Models\Favorite;

class FavoriteRepository
{
    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->where('user_id', auth()->user()->id)->get();
    }

    /**
     * Add to favorites
     *
     * @param int $productId
     *
     * @return Favorite
     */
    public function add($productId)
    {
        return $this->model->firstOrCreate([
            'product_id' => $productId,
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * Removes from favorites
     *
     * @param int $productId
     *
     * @return bool
     */
    public function remove($productId)
    {
        return $this->model->where([
            'product_id' => $productId,
            'user_id' => auth()->user()->id
        ])->delete();
    }
}
