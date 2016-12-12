<?php

namespace Quarx\Modules\Hadron\Services;

use DB;
use Customer;
use Quarx\Modules\Hadron\Models\Orders;
use Quarx\Modules\Hadron\Models\Transactions;

class PaymentService
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->transaction = app(Transactions::class);
        $this->orders = app(Orders::class);
        $this->logistic = app(LogisticService::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    public function purchase($request, $cart)
    {
        $user = auth()->user();

        if (is_null($user->meta->stripe_id) && $request->input('stripeToken')) {
            $user->meta->createAsStripeCustomer($request->input('stripeToken'));
        } elseif ($request->input('stripeToken')) {
            $user->meta->updateCard($request->input('stripeToken'));
        }

        DB::beginTransaction();

        $result = $user->meta->charge(($cart->getCartTotal() * 100), [
            'currency' => env('CURRENCY'),
        ]);

        if ($result) {
            $transaction = $this->transaction->create([
                'uuid' => md5(time()).'-'.$user->id,
                'provider' => 'stripe',
                'state' => 'success',
                'subtotal' => $cart->getCartSubTotal(),
                'tax' => $cart->getCartTax(),
                'total' => $cart->getCartTotal(),
                'shipping' => $this->logistic->shipping($user),
                'provider_id' => $result->id,
                'provider_date' => $result->created,
                'provider_dispute' => '',
                'cart' => json_encode($cart->contents()),
                'response' => json_encode($result),
                'customer_id' => $user->id,
            ]);

            $orderedItems = [];
            foreach ($cart->contents() as $item) {
                if (!$item->is_download) {
                    $orderedItems[] = $item;
                }
            }

            if (!empty($orderedItems)) {
                $this->createOrder($user, $transaction, $orderedItems);
            }
        }

        DB::commit();

        return $this->logistic->afterPurchase($user, $transaction, $cart, $result);
    }

    public function createOrder($user, $transaction, $items)
    {
        $this->orders->create([
            'user_id' => $user->id,
            'transaction_id' => $transaction->id,
            'details' => json_encode($items),
            'shipping_address' => json_encode([
                'street' => Customer::shippingAddress('street'),
                'postal' => Customer::shippingAddress('postal'),
                'city' => Customer::shippingAddress('city'),
                'state' => Customer::shippingAddress('state'),
                'country' => Customer::shippingAddress('country'),
             ]),
        ]);
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

    //     if (!$refundData) {
    //         return array('status' => 'error', 'data' => Module::lang('store.notifications.payment.refund-fail'));
    //     } else {
    //         return array('status' => 'success', 'data' => $refundData);
    //     }
    // }
}
