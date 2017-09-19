<?php

namespace Yab\Quazar\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yab\Crypto\Services\Crypto;
use Yab\Quazar\Models\Coupon;
use Yab\Quazar\Models\Transaction;

class PaymentService
{
    public $user;

    public function __construct(
        Transaction $transaction,
        OrderService $orderService,
        LogisticService $logisticService,
        OrderItemService $orderItemService
    ) {
        $this->user = auth()->user();
        $this->transaction = $transaction;
        $this->orderService = $orderService;
        $this->logistic = $logisticService;
        $this->orderItemService = $orderItemService;
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    /**
     * Make a purchase.
     *
     * @param string $stripeToken
     * @param Cart   $cart
     *
     * @return mixed
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

        $coupon = null;

        if (Session::get('coupon_code')) {
            $coupon = json_encode(app(Coupon::class)->where('code', Session::get('coupon_code'))->first());
        }

        $result = $user->meta->charge(($cart->getCartTotal() * 100), [
            'currency' => config('quazar.currency', 'usd'),
        ]);

        if ($result) {
            $transaction = $this->transaction->create([
                'uuid' => Crypto::uuid(),
                'provider' => 'stripe',
                'state' => 'success',
                'subtotal' => $cart->getCartSubTotal(),
                'coupon' => $coupon,
                'tax' => $cart->getCartTax(),
                'total' => $cart->getCartTotal(),
                'shipping' => $this->logistic->shipping($user),
                'provider_id' => $result->id,
                'provider_date' => $result->created,
                'provider_dispute' => '',
                'cart' => json_encode($cart->contents()),
                'response' => json_encode($result),
                'user_id' => $user->id,
            ]);

            $cart->removeCoupon();

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

    /**
     * Create an order.
     *
     * @param User        $user
     * @param Transaction $transaction
     * @param array       $items
     *
     * @return mixed
     */
    public function createOrder($user, $transaction, $items)
    {
        $customerService = app(CustomerProfileService::class);

        $shippingAddress = json_encode([
            'street' => $customerService->shippingAddress('street'),
            'postal' => $customerService->shippingAddress('postal'),
            'city' => $customerService->shippingAddress('city'),
            'state' => $customerService->shippingAddress('state'),
            'country' => $customerService->shippingAddress('country'),
        ]);

        $order = $this->orderService->create([
            'uuid' => Crypto::uuid(),
            'user_id' => $user->id,
            'transaction_id' => $transaction->id,
            'details' => json_encode($items),
            'shipping_address' => $shippingAddress,
        ]);

        foreach ($items as $product) {
            $productCost = $this->orderItemService->getCostDetails($product);

            $this->orderItemService->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $product->quantity,
                'variants' => $product->product_variants,
                'subtotal' => $productCost['subtotal'],
                'shipping' => $productCost['shipping'],
                'tax' => $productCost['tax'],
                'total' => $productCost['total'],
            ]);
        }

        return $this->logistic->afterPlaceOrder($user, $transaction, $items);
    }
}
