<?php

namespace Quarx\Modules\Hadron\Repositories;

use Illuminate\Support\Facades\Schema;
use Quarx\Modules\Hadron\Models\Orders;

class OrderRepository
{
    /**
     * Returns all Orders.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Orders::orderBy('created_at', 'desc')->all();
    }

    public function paginated()
    {
        return Orders::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($payload)
    {
        $query = Orders::orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('orders');

        $query->where('id', '>', 0);

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return [$query, $payload, $query->paginate(25)->render()];
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
        return Orders::create($payload);
    }

    /**
     * Find Orders by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Orders
     */
    public function findOrdersById($id)
    {
        return Orders::find($id);
    }

    /**
     * Find Orders by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Orders
     */
    public function getByCustomer($id)
    {
        return Orders::where('customer_id', '=', $id);
    }

    /**
     * Find Orders by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Orders
     */
    public function getByCustomerAndId($customer, $id)
    {
        return Orders::where('customer_id', $customer)->where('id', $id)->first();
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
        if (isset($payload['is_shipped'])) {
            $payload['is_shipped'] = true;
        } else {
            $payload['is_shipped'] = false;
        }

        return $order->update($payload);
    }
}
