<?php

namespace Sitec\Commerce\Services;

use Illuminate\Support\Facades\Session;

class CustomerProfileService
{
    /**
     * User has profile.
     *
     * @return bool
     */
    public function hasProfile()
    {
        return (bool) auth()->user()->meta->card_last_four;
    }

    /**
     * Get user shipping address.
     *
     * @param string $key
     *
     * @return string
     */
    public function shippingAddress($key = null)
    {
        if (auth()->user()) {
            $profile = auth()->user()->meta;
            $address = json_decode($profile->shipping_address);
        } else {
            $address = Session::get('shipping_address', (object) []);
        }

        if (is_null($key)) {
            return $address;
        } elseif (isset($address->$key)) {
            return $address->$key;
        }

        return '';
    }

    /**
     * Get user billing address.
     *
     * @param string $key
     *
     * @return string
     */
    public function billingAddress($key = null)
    {
        if (auth()->user()) {
            $profile = auth()->user()->meta;
            $address = json_decode($profile->billing_address);
        } else {
            $address = Session::get('billing_address', (object) []);
        }

        if (is_null($key)) {
            return $address;
        } elseif (isset($address->$key)) {
            return $address->$key;
        }

        return '';
    }

    /**
     * Get the last card.
     *
     * @param string $key
     *
     * @return string
     */
    public function lastCard($key = null)
    {
        $profile = auth()->user()->meta;

        if (is_null($key)) {
            $response = [
                'card_brand' => $profile->card_brand,
                'card_last_four' => $profile->card_last_four,
            ];
        } else {
            $response = $profile->$key;
        }

        return $response;
    }

    /**
     * Update the user profile.
     *
     * @param string $address
     *
     * @return bool
     */
    public function updateProfileAddress($address)
    {
        $addressInput = [
            'street' => $address['street'],
            'postal' => $address['postal'],
            'city' => $address['city'],
            'state' => $address['state'],
            'country' => $address['country'],
        ];

        $profileData = [];

        if (isset($address['shipping'])) {
            $profileData['shipping_address'] = json_encode($addressInput);
        }

        if (isset($address['billing'])) {
            $profileData['billing_address'] = json_encode($addressInput);
        }

        if (is_null(auth()->user()->meta->shipping_address)) {
            $profileData['shipping_address'] = json_encode($addressInput);
        }

        if (is_null(auth()->user()->meta->billing_address)) {
            $profileData['billing_address'] = json_encode($addressInput);
        }

        return auth()->user()->meta()->update($profileData);
    }
}
