<?php

namespace Quarx\Modules\Hadron\Services;

use App\Services\StoreLogistics;
use Quarx\Modules\Hadron\Interfaces\LogisticServiceInterface;

class LogisticService implements LogisticServiceInterface
{
    public function __construct(
        CartService $cart,
        StoreLogistics $storeLogistics
    ) {
        $this->cartService = $cart;
        $this->storeLogistics = $storeLogistics;
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
        return $this->storeLogistics->shipping($user);
    }

    /**
     * Calculate the Tax.
     *
     * @return int
     */
    public function getTaxPercent($user)
    {
        return $this->storeLogistics->getTaxPercent($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases & Refunds
    |--------------------------------------------------------------------------
    */

    public function afterPurchase($user, $transaction, $cart, $result)
    {
        return $this->storeLogistics->afterPurchase($user, $transaction, $cart, $result);
    }

    public function afterSubscription($user, $plan)
    {
        return $this->storeLogistics->afterSubscription($user, $plan);
    }

    public function afterRefundRequest($transaction)
    {
        return $this->storeLogistics->afterRefundRequest($transaction);
    }

    public function afterRefund($transaction)
    {
        return $this->storeLogistics->afterRefund($transaction);
    }

    public function cancelSubscription($user, $plan)
    {
        return $this->storeLogistics->cancelSubscription($user, $plan);
    }

    public function afterPlaceOrder($user, $transaction, $cart)
    {
        return $this->storeLogistics->afterPlaceOrder($user, $transaction, $cart);
    }

    public function orderCreated($order)
    {
        return $this->storeLogistics->orderCreated($order);
    }

    public function shipOrder($order)
    {
        return $this->storeLogistics->shipOrder($order);
    }

    public function cancelOrder($order)
    {
        return $this->storeLogistics->cancelOrder($order);
    }
}
