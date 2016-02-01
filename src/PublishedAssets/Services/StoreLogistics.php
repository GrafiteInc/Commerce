<?php

namespace App\Services;

use Customer;
use Yab\Hadron\Interfaces\LogisticServiceInterface;

class StoreLogistics implements LogisticServiceInterface
{

    /**
     * Calculate the shipping cost
     *
     * @param  user $user
     * @return int
     */
    public function shipping($user)
    {
        $address = Customer::shippingAddress();
        $weight = $this->cartWeight();

        return 0;
    }

    /**
     * Calculate the Tax
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
        # code...
    }

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    public function afterPlaceOrder($user, $transaction, $cart)
    {
        // places order into orders table
    }

    public function shipOrder()
    {
        // sets order to shipped - and does any needed logic
    }

    public function generateOrderLabel()
    {
        // creates an order shipping label
    }

    public function updateOrderWithTracking()
    {
        // updates the order with a tracking value
    }

    /*
    |--------------------------------------------------------------------------
    | Digital Products
    |--------------------------------------------------------------------------
    */

    public function createDownloadLink()
    {
        # code...
    }

    /*
    |--------------------------------------------------------------------------
    | Subscriptions
    |--------------------------------------------------------------------------
    */

    public function createSubscription()
    {
        # code...
    }

}