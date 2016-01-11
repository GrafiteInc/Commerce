<?php

namespace App\Services;

use Mlantz\Hadron\Interfaces\LogisticServiceInterface;

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
        $weight = $this->cartWeight();

        return 0;
    }

    /**
     * Calculate the Tax
     * @return int
     */
    public function getTaxPercent($user)
    {
        return 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    public function placeOrder()
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