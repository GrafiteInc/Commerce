<?php

namespace Mlantz\Hadron\Services;

use App\Services\StoreLogistics;
use Mlantz\Hadron\Repositories\CartRepository;
use Mlantz\Hadron\Interfaces\LogisticServiceInterface;

class LogisticService extends StoreLogistics implements LogisticServiceInterface
{
    public function __construct(CartService $cart)
    {
        $this->cartService = $cart;
    }

    public function cartWeight()
    {
        $weight = 0;
        $cartContents = $this->cartService->contents();

        foreach ($cartContents as $item) {
            $weight += (float) $item->weight;
        }

        return $weight;
    }

    public function purchase()
    {
        # code...
    }

}