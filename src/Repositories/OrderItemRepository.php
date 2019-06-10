<?php

namespace Sitec\Commerce\Repositories;

use Illuminate\Support\Facades\Schema;
use Sitec\Commerce\Models\OrderItem;

class OrderItemRepository
{
    public $model;

    public function __construct(OrderItem $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all Orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->all();
    }

    /**
     * Returns all paginated Orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginated($count)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($count);
    }

    /**
     * Searches the orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($payload, $count)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('order_items');
        $query->where('id', '>', 0);
        $query->where('id', 'LIKE', '%'.$payload.'%');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return [$query, $payload, $query->paginate($count)->render()];
    }

    /**
     * Stores Orders into database.
     *
     * @param array $payload
     *
     * @return Orders
     */
    public function store($payload)
    {
        return $this->model->create($payload);
    }

    /**
     * Find Orders by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Orders
     */
    public function findItemsByOrderId($id)
    {
        return $this->model->where('order_id', $id)->get();
    }

    /**
     * Updates Orders into database.
     *
     * @param Order $order
     * @param array $payload
     *
     * @return Orders
     */
    public function update($order, $payload)
    {
        return $order->update($payload);
    }
}
