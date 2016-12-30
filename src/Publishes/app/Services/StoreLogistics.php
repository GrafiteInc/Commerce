<?php

namespace App\Services;

use Customer;
use Illuminate\Support\Facades\Log;
use Quarx\Modules\Hadron\Interfaces\LogisticServiceInterface;
use Quarx\Modules\Hadron\Services\LogisticService;

class StoreLogistics implements LogisticServiceInterface
{
    /**
     * Calculate the shipping cost.
     *
     * @param user $user
     *
     * @return int
     */
    public function shipping($user)
    {
        $address = Customer::shippingAddress();
        $weight = app(LogisticService::class)->cartWeight();

        return 0;
    }

    /**
     * Calculate the Tax.
     *
     * @return int
     */
    public function getTaxPercent($user)
    {
        $address = Customer::billingAddress();

        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases & Refunds
    |--------------------------------------------------------------------------
    */

    public function afterPurchase($user, $transaction, $cart, $result)
    {
        Log::info('After purchase');

        if ($result) {
            $cart->emptyCart();

            return redirect('store/complete');
        } else {
            return redirect('store/failed');
        }
    }

    public function afterSubscription($user, $plan)
    {
        // code...
        Log::info('After subscription');
    }

    public function afterRefundRequest($transaction)
    {
        // code...
        Log::info('After refund request');
    }

    public function afterRefund($transaction)
    {
        // code...
        Log::info('After refund');
    }

    public function cancelSubscription($user, $plan)
    {
        // code...
        Log::info('Cancel subscription');
    }

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    public function afterPlaceOrder($user, $transaction, $cart)
    {
        // places order into orders table
        Log::info('Order was placed');
    }

    public function orderCreated($order)
    {
        // sets order to shipped - and does any needed logic
        Log::info('Order was shipped');
    }

    public function shipOrder($order)
    {
        // sets order to shipped - and does any needed logic
        Log::info('Order was shipped');
    }

    public function cancelOrder($order)
    {
        // sets order to shipped - and does any needed logic
        Log::info('Order was cancelled');
    }
}
