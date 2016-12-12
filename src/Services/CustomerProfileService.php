<?php

namespace Quarx\Modules\Hadron\Services;

class CustomerProfileService
{
    public function hasProfile()
    {
        return (bool) auth()->user()->meta->shipping_address;
    }

    public function shippingAddress($key = null)
    {
        $profile = auth()->user()->meta;
        $address = json_decode($profile->shipping_address);
        if (is_null($key)) {
            return $address;
        } elseif (isset($address->$key)) {
            return $address->$key;
        }

        return '';
    }

    public function billingAddress($key = null)
    {
        $profile = auth()->user()->meta;
        $address = json_decode($profile->billing_address);
        if (is_null($key)) {
            return $address;
        } elseif (isset($address->$key)) {
            return $address->$key;
        }

        return '';
    }

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

        return auth()->user()->meta->update($profileData);
    }
}
