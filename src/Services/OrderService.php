<?php

namespace Yab\Quazar\Services;

use Illuminate\Support\Facades\Config;
use Yab\Quazar\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        OrderRepository $orderRepository,
        LogisticService $logisticService
    ) {
        $this->repo = $orderRepository;
        $this->logistics = $logisticService;
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

        if (isset($payload['is_shipped'])) {
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
    public function cancelOrder($id)
    {
        $order = $this->repo->findOrdersById($id);

        if ($order->status != 'complete') {
            $this->logistics->cancelOrder($order);
            app(TransactionService::class)->refund($order->transaction('uuid'));

            return $this->update($order->id, [
                'status' => 'cancelled',
                'is_shipped' => false,
            ]);
        }

        return false;
    }
}
