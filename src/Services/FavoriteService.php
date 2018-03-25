<?php

namespace Grafite\Commerce\Services;

use Grafite\Commerce\Repositories\FavoriteRepository;

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
