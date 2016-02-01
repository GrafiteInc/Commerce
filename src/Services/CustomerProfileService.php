<?php

namespace Yab\Hadron\Services;

use Quarx;
use Config;
use FileService;
use CryptoService;
use Illuminate\Support\Facades\Auth;
use Yab\Hadron\Services\StripeService;
use Yab\Hadron\Repositories\CustomerProfileRepository;
use Yab\Hadron\Repositories\ProductVariantRepository;

class CustomerProfileService
{

    public function __construct(CustomerProfileRepository $customerProfile, StripeService $stripeService)
    {
        $this->repo = $customerProfile;
        $this->stripeService = $stripeService;
    }

    public function hasProfile()
    {
        return (bool) $this->repo->getCustomerProfile(Auth::id());
    }

    public function shippingAddress($key = null)
    {
        $profile = $this->repo->getCustomerProfile(Auth::id());
        $address = json_decode($profile->shipping_address);
        if (is_null($key)) {
            return $address;
        } else if (isset($address->$key)) {
            return $address->$key;
        }

        return '';
    }

    public function billingAddress($key = null)
    {
        $profile = $this->repo->getCustomerProfile(Auth::id());
        $address = json_decode($profile->billing_address);
        if (is_null($key)) {
            return $address;
        } else if (isset($address->$key)) {
            return $address->$key;
        }

        return '';
    }

    public function lastCard($key = null)
    {
        $profile = $this->repo->getCustomerProfile(Auth::id());

        $response = $profile->$key;

        if (is_null($key)) {
            $response = [
                'card_brand' => $profile->card_brand,
                'card_last_four' => $profile->card_last_four
            ];
        }

        return $response;
    }

    public function findByUserId($id)
    {
        return $this->repo->findByUserId($id);
    }

    public function updateProfile($profileId, $cardData)
    {
        $profileData = $this->stripeService->createCustomer($profileId, $cardData);
        return $this->repo->updateProfile($profileId, $profileData);
    }

    public function updateProfileAddress($profileId, $address)
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

        return $this->repo->updateProfile($profileId, $profileData);
    }

}
