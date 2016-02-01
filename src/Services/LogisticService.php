<?php

namespace Yab\Hadron\Services;

use App\Services\StoreLogistics;
use Yab\Hadron\Repositories\CartRepository;
use Yab\Hadron\Interfaces\LogisticServiceInterface;

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

}