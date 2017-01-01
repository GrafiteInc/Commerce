<?php

namespace Quarx\Modules\Hadron\Services;

use App\Services\StoreLogistics;
use Quarx\Modules\Hadron\Interfaces\LogisticServiceInterface;

class LogisticService implements LogisticServiceInterface
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

    public function shipping($user)
    {
        return app(StoreLogistics::class)->shipping($user);
    }

    /**
     * Calculate the Tax.
     *
     * @return int
     */
    public function getTaxPercent($user)
    {
        return app(StoreLogistics::class)->getTaxPercent($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases & Refunds
    |--------------------------------------------------------------------------
    */

    public function afterPurchase($user, $transaction, $cart, $result)
    {
        return app(StoreLogistics::class)->afterPurchase($user, $transaction, $cart, $result);
    }

    public function afterSubscription($user, $plan)
    {
        return app(StoreLogistics::class)->afterSubscription($user, $plan);
    }

    public function afterRefundRequest($transaction)
    {
        return app(StoreLogistics::class)->afterRefundRequest($transaction);
    }

    public function afterRefund($transaction)
    {
        return app(StoreLogistics::class)->afterRefund($transaction);
    }

    public function cancelSubscription($user, $plan)
    {
        return app(StoreLogistics::class)->cancelSubscription($user, $plan);
    }

    public function afterPlaceOrder($user, $transaction, $cart)
    {
        return app(StoreLogistics::class)->afterPlaceOrder($user, $transaction, $cart);
    }

    public function orderCreated($order)
    {
        return app(StoreLogistics::class)->orderCreated($order);
    }

    public function shipOrder($order)
    {
        return app(StoreLogistics::class)->shipOrder($order);
    }

    public function cancelOrder($order)
    {
        return app(StoreLogistics::class)->cancelOrder($order);
    }
}
