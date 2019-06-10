<?php

namespace SierraTecnologia\Commerce\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use SierraTecnologia\Commerce\Models\Transaction;
use SierraTecnologia\Commerce\Services\LogisticService;

class TransactionRepository
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * Returns all Transactions.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * Returns all Transactions for the last three months.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function overMonths($months = 1)
    {
        $threeMonthsAgo = Carbon::now()->subMonths($months)->format('Y-m-d 00:00:00');
        $now = Carbon::now()->format('Y-m-d 23:59:59');

        return $this->model->orderBy('created_at', 'asc')->where('created_at', '>=', $threeMonthsAgo)->where('created_at', '<=', $now)->get();
    }

    /**
     * Returns paginated Transactions.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginated()
    {
        if (isset(request()->dir) && isset(request()->field)) {
            $model = $this->model->orderBy(request()->field, request()->dir);
        } else {
            $model = $this->model->orderBy('created_at', 'desc');
        }

        return $model->paginate(config('cms.pagination', 25));
    }

    /**
     * Search the Transactions.
     *
     * @param array $payload
     * @param int   $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($payload, $paginate)
    {
        $query = $this->model->orderBy('created_at', 'desc');
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
     * @param array $payload
     *
     * @return Transactions
     */
    public function store($payload)
    {
        return $this->model->create($payload);
    }

    /**
     * Find Transactions by ID.
     *
     * @param int $id
     *
     * @return Transactions
     */
    public function find($id)
    {
        return $this->model->find($id);
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
        return $this->model->where('uuid', $uuid)->firstOrFail();
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
        return $this->model->where('user_id', '=', $id);
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
        return $this->model->where('user_id', $customer)->where('id', $id)->first();
    }

    /**
     * Find Transactions by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Transactions
     */
    public function getByCustomerAndUuid($customer, $uuid)
    {
        return $this->model->where('user_id', $customer)->where('uuid', $uuid)->first();
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
    public function requestRefund($authId, $transactionId)
    {
        $transaction = $this->getByCustomerAndUuid($authId, $transactionId);

        app(LogisticService::class)->afterRefundRequest($transaction);

        return $transaction->update([
            'refund_requested' => true,
        ]);
    }
}
