<?php

namespace Quarx\Modules\Hadron\Services;

use Illuminate\Support\Facades\Config;
use Quarx\Modules\Hadron\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        OrderRepository $orderRepository,
        LogisticService $logisticService
    ) {
        $this->repo = $orderRepository;
        $this->logistics = $logisticService;
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

        $this->logistics->orderCreated($order);

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
            $this->logistics->shipOrder($order);
        }

        return $this->repo->update($order, $payload);
    }

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
