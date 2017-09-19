<?php

namespace Yab\Quazar\Services;

use Yab\Quazar\Models\Refund;
use Yab\Crypto\Services\Crypto;
use Illuminate\Support\Facades\Config;
use Yab\Quazar\Services\TransactionService;
use Yab\Quazar\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        OrderRepository $orderRepository,
        LogisticService $logisticService,
        TransactionService $transactionService
    ) {
        $this->repo = $orderRepository;
        $this->logistics = $logisticService;
        $this->transactions = $transactionService;
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
        return $this->repo->paginated(config('quarx.pagination', 25));
    }

    /**
     * Find the Order by ID.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function findOrdersById($id)
    {
        return $this->repo->findOrdersById($id);
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
        return $this->repo->search($payload, config('quarx.pagination', 25));
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
        $order = $this->repo->store($payload);

        $this->logistics->orderCreated($order);

        return $order;
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
        return $this->repo->findOrdersById($id);
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

        if (isset($payload['is_shipped']) && $payload['is_shipped'] !== false) {
            $this->logistics->shipOrder($order);
        }

        return $this->repo->update($order, $payload);
    }

    /**
     * Cancel an order.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function cancelOrder($customerId, $uuid)
    {
        $order = $this->repo->getByCustomerAndUuid($customerId, $uuid);

        if ($order->status != 'complete') {
            $this->logistics->cancelOrder($order);

            foreach ($order->items as $item) {
                $item->update([
                    'was_refunded' => true,
                    'status' => 'cancelled',
                ]);
            }

            if (!$order->hasActiveOrderItems()) {
                $refund = $this->transactions->refund($order->transaction('uuid'));

                app(Refund::class)->create([
                    'transaction_id' => $order->transaction('id'),
                    'provider_id' => $refund->id,
                    'uuid' => Crypto::uuid(),
                    'amount' => ($refund->amount * 0.01),
                    'provider' => 'Stripe',
                    'charge' => $refund->charge,
                    'currency' => $refund->currency,
                ]);
            }

            return $this->update($order->id, [
                'status' => 'cancelled',
                'is_shipped' => false,
            ]);
        }

        return false;
    }
}
