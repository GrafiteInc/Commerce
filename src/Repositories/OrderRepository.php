<?php

namespace Yab\Hadron\Repositories;

use Yab\Hadron\Models\Orders;
use Illuminate\Support\Facades\Schema;

class OrderRepository
{

    /**
     * Returns all Orders
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

    public function search($input)
    {
        $query = Orders::orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('orders');

        $query->where('id', '>', 0);

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        };

        return [$query, $input['term'], $query->paginate(25)->render()];
    }

    /**
     * Stores Orders into database
     *
     * @param array $input
     *
     * @return Orders
     */
    public function store($input)
    {
        return Orders::create($input);
    }

    /**
     * Find Orders by given id
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
     * Find Orders by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Orders
     */
    public function getByCustomer($id)
    {
        return Orders::where('user_id', '=', $id);
    }

    /**
     * Find Orders by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Orders
     */
    public function getByCustomerAndId($customer, $id)
    {
        return Orders::where('user_id', $customer)->where('id', $id)->first();
    }

    /**
     * Updates Orders into database
     *
     * @param Orders $orders
     * @param array $input
     *
     * @return Orders
     */
    public function update($orders, $input)
    {
        $orders->fill($input);
        $orders->save();

        return $orders;
    }
}