<?php

namespace Yab\Hadron\Services;

use DB;
use App;
use Auth;
use Customer;
use Yab\Hadron\Models\Orders;
use Yab\Hadron\Models\Transactions;
use Yab\Hadron\Services\LogisticService;

class PaymentService
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->transaction = new Transactions;
        $this->orders = new Orders;
        $this->customerService = App::make('Yab\Hadron\Services\CustomerProfileService');
        $this->stripeService = App::make('Yab\Hadron\Services\StripeService');
        $this->logistic = App::make('Yab\Hadron\Services\LogisticService');
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    public function purchase($request, $cart)
    {
        $cardData = [
            'number' => $request->input('number'),
            'expiryMonth' => $request->input('exp_month'),
            'expiryYear' => $request->input('exp_year'),
            'cvv' => $request->input('cvv')
        ];

        $customerProfile = $this->customerService->findByUserId(Auth::id());

        if (! $customerProfile->stripe_id) {
            $customerProfile = $this->customerService->updateProfile($customerProfile->id, $cardData);
        }

        DB::beginTransaction();

        $result = $this->stripeService->charge($customerProfile, ($cart->getCartTotal() * 100), env('CURRENCY'));

        if ($result) {
            $transaction = $this->transaction->create([
                'uuid' => md5(time()).'-'.Auth::id(),
                'provider' => 'stripe',
                'state' => 'success',
                'subtotal' => $cart->getCartSubTotal(),
                'tax' => $cart->getCartTax(),
                'total' => $cart->getCartTotal(),
                'shipping' => $this->logistic->shipping(Auth::user()),
                'provider_id' => $result->id,
                'provider_date' => $result->created,
                'provider_dispute' => '',
                'cart' => json_encode($cart->contents()),
                'response' => json_encode($result),
                'customer_id' => Auth::id(),
            ]);

            $this->orders->create([
                'user_id' => Auth::id(),
                'transaction_id' => $transaction->id,
                'details' => json_encode($cart->contents()),
                'shipping_address' => json_encode([
                    'street' => Customer::shippingAddress('street'),
                    'postal' => Customer::shippingAddress('postal'),
                    'city' => Customer::shippingAddress('city'),
                    'state' => Customer::shippingAddress('state'),
                    'country' => Customer::shippingAddress('country'),
                 ])
            ]);
        }

        DB::commit();

        return $this->logistic->afterPurchase(Auth::user(), $transaction, $cart, $result);
    }

    // public function success()
    // {
    //     Logistics::setOrder($this->cart->getShoppingCart());

    //     $result = $this->gateway->success($this->user);

    //     return $result;
    // }

    // public function cancelled()
    // {
    //     $result = $this->gateway->cancelled($this->user);

    //     Logistics::cancelOrder($result);

    //     return $result;
    // }

    // public function refundPurchase($transaction)
    // {
    //     $refundData = $this->gateway->refund($this->user, $transaction);

    //     Logistics::refundOrder($refundData);

    //     if ( ! $refundData) {
    //         return array('status' => 'error', 'data' => Module::lang('store.notifications.payment.refund-fail'));
    //     } else {
    //         return array('status' => 'success', 'data' => $refundData);
    //     }
    // }
}