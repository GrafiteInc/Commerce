<?php

namespace Sitec\Commerce\Services;

use Sitec\Commerce\Repositories\FavoriteRepository;

class FavoriteService
{
    public function __construct(FavoriteRepository $repo)
    {
        $this->repo = $repo;
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function add($productId)
    {
        return $this->repo->add($productId);
    }

    public function remove($productId)
    {
        return $this->repo->remove($productId);
    }
}
