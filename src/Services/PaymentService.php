<?php

namespace SierraTecnologia\Commerce\Services;

use SierraTecnologia\Commerce\Models\Coupon;
use SierraTecnologia\Commerce\Models\Transaction;
use SierraTecnologia\Commerce\Services\TransactionService;
use SierraTecnologia\Crypto\Services\Crypto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentService
{
    public $user;

    public function __construct(
        Transaction $transaction,
        OrderService $orderService,
        LogisticService $logisticService,
        OrderItemService $orderItemService,
        TransactionService $transactionService
    ) {
        $this->user = auth()->user();
        $this->transaction = $transaction;
        $this->orderService = $orderService;
        $this->logistic = $logisticService;
        $this->orderItemService = $orderItemService;
        $this->transactionService = $transactionService;
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
        } else if ($stripeToken) {
            $user->meta->updateCard($stripeToken);
        }

        DB::beginTransaction();

        $coupon = null;

        if (Session::get('coupon_code')) {
            $coupon = json_encode(app(Coupon::class)->where('code', Session::get('coupon_code'))->first());
        }

        $result = $user->meta->charge(($cart->getCartTotal() * 100), [
            'currency' => config('commerce.currency', 'usd'),
        ]);

        if ($result) {
            $transaction = $this->transactionService->create([
                'uuid' => Crypto::uuid(),
                'provider' => 'stripe',
                'state' => 'success',
                'coupon' => $coupon,
                'subtotal' => $cart->getCartSubTotal(),
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
                $orderedItems[] = $item;
            }

            $this->createOrder($user, $transaction, $orderedItems);
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
                'transaction_id' => $transaction->id,
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
