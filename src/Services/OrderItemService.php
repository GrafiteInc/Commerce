<?php

namespace Sitec\Commerce\Services;

use Carbon\Carbon;
use Stripe\Error\InvalidRequest;
use Sitec\Crypto\Services\Crypto;
use Sitec\Commerce\Models\Refund;
use Sitec\Commerce\Repositories\OrderItemRepository;
use Sitec\Commerce\Services\CartService;
use Sitec\Commerce\Services\LogisticService;
use Sitec\Commerce\Services\TransactionService;

class OrderItemService
{
    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->repo = $orderItemRepository;
    }

    /**
     * Get all Orders.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repo->all();
    }

    /**
     * Get all Orders.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated()
    {
        return $this->repo->paginated(config('cms.pagination', 25));
    }

    /**
     * Find the Order by ID.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function findItemsByOrderId($id)
    {
        return $this->repo->findItemsByOrderId($id);
    }

    /**
     * Search the orders.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        return $this->repo->search($payload, config('cms.pagination', 25));
    }

    /**
     * Create an order.
     *
     * @param array $payload
     *
     * @return Orders
     */
    public function create($payload)
    {
        $payload['tax'] = $payload['tax'] * 100;
        $payload['shipping'] = $payload['shipping'] * 100;
        $payload['subtotal'] = $payload['subtotal'] * 100;
        $payload['total'] = $payload['total'] * 100;

        return $this->repo->store($payload);
    }

    /**
     * Find an order.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function find($id)
    {
        return $this->repo->model->find($id);
    }

    /**
     * Update an order.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return Orders
     */
    public function update($id, $payload)
    {
        $order = $this->find($id);

        return $this->repo->update($order, $payload);
    }

    /**
     * Cancel an order Item
     *
     * @param  int $id
     *
     * @return bool
     */
    public function cancel($id)
    {
        try {
            $orderItem = $this->find($id);

            $transaction = null;
            $amount = $orderItem->amount;

            if ($orderItem->transaction) {
                $transaction = $orderItem->transaction;
            } else {
                $transaction = $orderItem->order->transaction();

                if ($orderItem->isLastNonRefundedItem()) {
                    $amount = null;
                }
            }

            $refund = app(TransactionService::class)->refund($transaction->uuid, $amount);

            if ($refund) {
                $orderItem->update([
                    'was_refunded' => true,
                    'status' => 'cancelled',
                ]);

                app(Refund::class)->create([
                    'transaction_id' => $transaction->id,
                    'order_item_id' => $orderItem->id,
                    'provider_id' => $refund->id,
                    'uuid' => Crypto::uuid(),
                    'amount' => ($refund->amount * 0.01),
                    'provider' => 'Stripe',
                    'charge' => $refund->charge,
                    'currency' => $refund->currency,
                ]);

                $orderItem->load('order');

                if (!$orderItem->order->hasActiveOrderItems()) {
                    $orderItem->order->update([
                        'status' => 'cancelled',
                    ]);
                    $orderItem->order->transaction()->update([
                        'refund_date' => Carbon::now(),
                    ]);
                }

                app(LogisticService::class)->afterRefund($transaction);
                app(LogisticService::class)->afterItemCancelled($orderItem);

                return true;
            }
        } catch (InvalidRequest $e) {
            return false;
        }
    }

    /*
     * --------------------------------------------------------------------------
     * Order Item Details
     * --------------------------------------------------------------------------
    */

    /**
     * Get the price details of a product
     *
     * @param  Product $product
     *
     * @return array
     */
    public function getCostDetails($product)
    {
        $cartService = app(CartService::class);

        $subtotal = $cartService->getItemSubtotal($product);
        $shipping = $cartService->getItemShipping($product);
        $tax = $cartService->getItemTax($product);

        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $subtotal + $shipping + $tax,
        ];
    }
}
