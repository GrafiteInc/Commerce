<?php

namespace Quarx\Modules\Hadron\Repositories;

use Quarx\Modules\Hadron\Models\Subscriptions;
use Illuminate\Support\Facades\Schema;

class SubscriptionRepository
{

    /**
     * Returns all Subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Subscriptions::orderBy('created_at', 'desc')->all();
    }

    public function paginated()
    {
        return Subscriptions::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($input)
    {
        $query = Subscriptions::orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('orders');

        $query->where('id', '>', 0);

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        };

        return [$query, $input['term'], $query->paginate(25)->render()];
    }

    /**
     * Stores Subscriptions into database
     *
     * @param array $input
     *
     * @return Subscriptions
     */
    public function store($input)
    {
        return Subscriptions::create($input);
    }

    /**
     * Find Subscriptions by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Subscriptions
     */
    public function findSubscriptionsById($id)
    {
        return Subscriptions::find($id);
    }

    /**
     * Find Subscriptions by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Subscriptions
     */
    public function getByCustomer($id)
    {
        return Subscriptions::where('user_id', '=', $id);
    }

    /**
     * Find Subscriptions by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Subscriptions
     */
    public function getByCustomerAndId($customer, $id)
    {
        return Subscriptions::where('user_id', $customer)->where('id', $id)->first();
    }

    /**
     * Updates Subscriptions into database
     *
     * @param Subscriptions $orders
     * @param array $input
     *
     * @return Subscriptions
     */
    public function update($orders, $input)
    {
        $orders->fill($input);
        $orders->save();

        return $orders;
    }
}