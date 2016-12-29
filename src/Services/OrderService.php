<?php

namespace Quarx\Modules\Hadron\Services;

use Config;
use Quarx;
use Quarx\Modules\Hadron\Repositories\OrderRepository;

class OrderService
{
    public function __construct(OrderRepository $orderRepository)
    {
        $this->repo = $orderRepository;
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function paginated()
    {
        return $this->repo->paginated(Config::get('quarx.pagination', 25));
    }

    public function findOrdersById($id)
    {
        return $this->repo->findOrdersById($id);
    }

    public function search($payload)
    {
        return $this->repo->search($payload, Config::get('quarx.pagination', 25));
    }

    public function create($payload)
    {
        $order = $this->repo->store($payload);

        app(LogisticService::class)->orderCreated($order);

        return $order;
    }

    public function find($id)
    {
        return $this->repo->findOrdersById($id);
    }

    public function update($id, $payload)
    {
        $order = $this->find($id);

        if (isset($payload['is_shipped'])) {
            app(LogisticService::class)->shipOrder($order);
        }

        return $this->repo->update($order, $payload);
    }

    public function cancelOrder($id)
    {
        $order = $this->repo->findOrdersById($id);

        if ($order->status != 'complete') {
            app(LogisticService::class)->cancelOrder($order);
            app(TransactionService::class)->refund($order->transaction('uuid'));

            return $this->update($order->id, [
                'status' => 'cancelled',
                'is_shipped' => false,
            ]);
        }

        return false;
    }
}
