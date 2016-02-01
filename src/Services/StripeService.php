<?php

namespace Yab\Hadron\Services;

use Auth;
use GuzzleHttp;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Charge;
use Stripe\Customer;

class StripeService
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCustomer($profile, $card)
    {
        $token = $this->getToken($card);

        $customer = Customer::create([
            'email' => Auth::user()->email,
            'card'  => $token
        ]);

        $customerData = [
            'user_id' => Auth::id(),
            'stripe_id' => $customer->id,
            'card_brand' => $token->card['brand'],
            'card_last_four' => $token->card['last4']
        ];

        return $customerData;
    }

    public function charge($customer, $amount, $currency)
    {
        return Charge::create([
            'customer' => $customer->stripe_id,
            'amount'   => $amount,
            'currency' => $currency
        ]);
    }

    public function changeCard()
    {
        # code...
    }

    private function getToken($card)
    {
        return Token::create([
            "card" => [
                "number" => $card["number"],
                "exp_month" => $card["expiryMonth"],
                "exp_year" => $card["expiryYear"],
                "cvc" => $card["cvv"]
            ]
        ]);
    }

}
