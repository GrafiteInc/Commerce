<?php

namespace Quarx\Modules\Hadron\Repositories;

use Carbon\Carbon;
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
        return Transactions::orderBy('created_at', 'desc')->get();
    }

    /**
     * Returns all Transactions for this year.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function thisYear()
    {
        return Transactions::orderBy('created_at', 'desc')->where('created_at', 'LIKE', Carbon::now()->format('Y').'-%')->get();
    }

    public function paginated()
    {
        return Transactions::orderBy('created_at', 'desc')->paginate(25);
    }

    public function search($payload, $paginate)
    {
        $query = Transactions::orderBy('created_at', 'desc');
        $query->where('id', 'LIKE', '%'.$payload.'%');

        $columns = Schema::getColumnListing('transactions');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return [$query, $payload, $query->paginate($paginate)->render()];
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
    public function findByUUID($uuid)
    {
        return Transactions::where('uuid', $uuid)->firstOrFail();
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
        return $transaction->update($payload);
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
