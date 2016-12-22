<?php

namespace App\Services;

use Customer;
use Illuminate\Support\Facades\Log;
use Quarx\Modules\Hadron\Interfaces\LogisticServiceInterface;

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
        $weight = $this->cartWeight();

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
    | Purchases
    |--------------------------------------------------------------------------
    */

    public function afterPurchase($user, $transaction, $cart, $result)
    {
        if ($result) {
            $cart->emptyCart();

            return redirect('store/complete');
        } else {
            return redirect('store/failed');
        }
    }

    public function afterRefundPurchase($user, $transaction, $cart)
    {
        // code...
        Log::info('After refund');
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

    public function shipOrder()
    {
        // sets order to shipped - and does any needed logic
        Log::info('Order was shipped');
    }

    public function generateOrderLabel()
    {
        // creates an order shipping label
        Log::info('Order label was made');
    }

    public function updateOrderWithTracking()
    {
        // updates the order with a tracking value
        Log::info('Order was updated');
    }

    public function cancelOrder()
    {
        // sets order to shipped - and does any needed logic
        Log::info('Order was cancelled');
    }

    /*
    |--------------------------------------------------------------------------
    | Digital Products
    |--------------------------------------------------------------------------
    */

    public function createDownloadLink()
    {
        // code...
        Log::info('Download link');
    }

    /*
    |--------------------------------------------------------------------------
    | Subscriptions
    |--------------------------------------------------------------------------
    */

    public function createSubscription()
    {
        // code...
        Log::info('Subscription was created');
    }
}
