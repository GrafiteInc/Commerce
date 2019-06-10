<?php

namespace SierraTecnologia\Commerce\Services;

use App\Services\StoreLogistics;
use SierraTecnologia\Commerce\Interfaces\LogisticServiceInterface;

class LogisticService implements LogisticServiceInterface
{
    public function __construct(CartService $cart)
    {
        $this->cartService = $cart;
    }

    /**
     * Get the cart weight.
     *
     * @return float
     */
    public function cartWeight()
    {
        $weight = 0;
        $cartContents = $this->cartService->contents();

        foreach ($cartContents as $item) {
            $weight += (float) $item->weight;
        }

        return $weight;
    }

    /**
     * Get cart shipping costs.
     *
     * @param User $user
     *
     * @return float
     */
    public function shipping($user)
    {
        return app(StoreLogistics::class)->shipping($user);
    }

    /**
     * Get single item shipping
     *
     * @param User $user
     *
     * @return float
     */
    public function singleItemShipping($item, $user)
    {
        return app(StoreLogistics::class)->singleItemShipping($user);
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

    /**
     * After the purchase of stuff.
     *
     * @param User        $user
     * @param Transaction $transaction
     * @param Cart        $cart
     * @param string      $result
     *
     * @return bool
     */
    public function afterPurchase($user, $transaction, $cart, $result)
    {
        return app(StoreLogistics::class)->afterPurchase($user, $transaction, $cart, $result);
    }

    /**
     * After subscription.
     *
     * @param User $user
     * @param Plan $plan
     *
     * @return bool
     */
    public function afterSubscription($user, $plan)
    {
        return app(StoreLogistics::class)->afterSubscription($user, $plan);
    }

    /**
     * After a refund request.
     *
     * @param Transaction $transaction
     *
     * @return bool
     */
    public function afterRefundRequest($transaction)
    {
        return app(StoreLogistics::class)->afterRefundRequest($transaction);
    }

    /**
     * After a refund.
     *
     * @param Transaction $transaction
     *
     * @return bool
     */
    public function afterRefund($transaction)
    {
        return app(StoreLogistics::class)->afterRefund($transaction);
    }

    /**
     * After a subscription cancel.
     *
     * @param Transaction $transaction
     *
     * @return bool
     */
    public function cancelSubscription($user, $plan)
    {
        return app(StoreLogistics::class)->cancelSubscription($user, $plan);
    }

    /**
     * After an order is placed.
     *
     * @param Transaction $transaction
     *
     * @return bool
     */
    public function afterPlaceOrder($user, $transaction, $cart)
    {
        return app(StoreLogistics::class)->afterPlaceOrder($user, $transaction, $cart);
    }

    /**
     * After an order is generated.
     *
     * @param Orders $order
     *
     * @return bool
     */
    public function orderCreated($order)
    {
        return app(StoreLogistics::class)->orderCreated($order);
    }

    /**
     * After an order is shipped.
     *
     * @param Orders $order
     *
     * @return bool
     */
    public function shipOrder($order)
    {
        return app(StoreLogistics::class)->shipOrder($order);
    }

    /**
     * Cancel an order.
     *
     * @param Orders $order
     *
     * @return bool
     */
    public function cancelOrder($order)
    {
        return app(StoreLogistics::class)->cancelOrder($order);
    }

    /**
     * After an Item has been cancelled
     *
     * @param Orders $order
     *
     * @return bool
     */
    public function afterItemCancelled($orderItem)
    {
        return app(StoreLogistics::class)->afterItemCancelled($orderItem);
    }
}
