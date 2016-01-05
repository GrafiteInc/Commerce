<?php

namespace Mlantz\Hadron\Repositories;

use Mlantz\Hadron\Models\Transactions;
use Illuminate\Support\Facades\Schema;

class TransactionRepository
{

    /**
     * Returns all Transactions
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Transactions::orderBy('created_at', 'desc')->all();
    }

    public function paginated()
    {
        return Transactions::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($input)
    {
        $query = Transactions::orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('transactions');

        $query->where('id', '>', 0);

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input['term'].'%');
        };

        return [$query, $input['term'], $query->paginate(25)->render()];
    }

    /**
     * Stores Transactions into database
     *
     * @param array $input
     *
     * @return Transactions
     */
    public function store($input)
    {
        return Transactions::create($input);
    }

    /**
     * Find Transactions by given id
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Transactions
     */
    public function findTransactionsById($id)
    {
        return Transactions::find($id);
    }

    /**
     * Updates Transactions into database
     *
     * @param Transactions $transactions
     * @param array $input
     *
     * @return Transactions
     */
    public function update($transactions, $input)
    {
        $transactions->fill($input);
        $transactions->save();

        return $transactions;
    }
}