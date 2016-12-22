<?php

namespace Quarx\Modules\Hadron\Repositories;

use Illuminate\Support\Facades\Schema;
use Quarx\Modules\Hadron\Models\Transactions;
use Quarx\Modules\Hadron\Services\LogisticService;

class TransactionRepository
{
    /**
     * Returns all Transactions.
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
        }

        return [$query, $input['term'], $query->paginate(25)->render()];
    }

    /**
     * Stores Transactions into database.
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
     * Find Transactions by given id.
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
     * Find Transactions by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Transactions
     */
    public function getByCustomer($id)
    {
        return Transactions::where('customer_id', '=', $id);
    }

    /**
     * Find Transactions by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Transactions
     */
    public function getByCustomerAndId($customer, $id)
    {
        return Transactions::where('customer_id', $customer)->where('id', $id)->first();
    }

    /**
     * Updates Transactions into database.
     *
     * @param Transactions $transactions
     * @param array        $payload
     *
     * @return Transactions
     */
    public function update($transaction, $payload)
    {
        $transaction->fill($payload);
        $transaction->save();

        return $transaction;
    }

    /**
     * Request a refund.
     *
     * @param int $transactionId
     *
     * @return bool
     */
    public function requestRefund($transactionId)
    {
        $transaction = Transactions::where('id', $transactionId);

        app(LogisticService::class)->afterRefundRequest($transaction);

        return $transaction->update([
            'refund_requested' => true,
        ]);
    }
}
