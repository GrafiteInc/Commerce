<?php

namespace Quarx\Modules\Hadron\Services;

use Customer;
use DB;
use Quarx\Modules\Hadron\Models\Transactions;
use Yab\Crypto\Services\Crypto;

class PaymentService
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->transaction = app(Transactions::class);
        $this->orderService = app(OrderService::class);
        $this->logistic = app(LogisticService::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    public function purchase($stripeToken, $cart)
    {
        $user = auth()->user();

        if (is_null($user->meta->stripe_id) && $stripeToken) {
            $user->meta->createAsStripeCustomer($stripeToken);
        } elseif ($stripeToken) {
            $user->meta->updateCard($stripeToken);
        }

        DB::beginTransaction();

        $result = $user->meta->charge(($cart->getCartTotal() * 100), [
            'currency' => env('CURRENCY'),
        ]);

        if ($result) {
            $transaction = $this->transaction->create([
                'uuid' => Crypto::uuid(),
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
        $this->orderService->create([
            'uuid' => Crypto::uuid(),
            'customer_id' => $user->id,
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

        return $this->logistic->afterPlaceOrder($user, $transaction, $items);
    }
}
