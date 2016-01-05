<?php

namespace Mlantz\Hadron\Services;

use Mlantz\Hadron\Repositories\CartRepository;
use Mlantz\Hadron\Repositories\ProductRepository;
use Mlantz\Hadron\Interfaces\LogisticServiceInterface;

class LogisticService implements LogisticServiceInterface
{
    public function __construct()
    {
        $this->cartService = new CartService;
        $this->productRepo = new ProductRepository;
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

    public function shipping($user)
    {
        $weight = $this->cartWeight();

        // Shipment logic goes here

        return 0;
    }

    public function getTaxPercent()
    {
        return 0;
    }

    public function shipProduct()
    {

    }

    public function generateLabel()
    {

    }

    public function updateWithTracking()
    {

    }

}