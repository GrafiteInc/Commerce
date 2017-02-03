<?php

namespace Yab\Quazar\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Yab\Quazar\Models\Orders;
use Yab\Quazar\Repositories\TransactionRepository;

class TransactionService
{
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->repo = $transactionRepository;
    }

    /**
     * Get all transactions.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->repo->all();
    }

    /**
     * Get all Transactions from this year.
     *
     * @return Collection
     */
    public function thisYear()
    {
        return $this->repo->thisYear();
    }

    /**
     * Get all Orders.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated()
    {
        return $this->repo->paginated(config('quarx.pagination', 25));
    }

    /**
     * Search the transactions.
     *
     * @param array $payload
     *
     * @return Collection
     */
    public function search($payload)
    {
        return $this->repo->search($payload, config('quarx.pagination', 25));
    }

    /**
     * Find an transaction.
     *
     * @param int $id
     *
     * @return Orders
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * Find an order by Transaction.
     *
     * @param int $id
     *
     * @return Transaction
     */
    public function getTransactionOrder($id)
    {
        return app(Orders::class)->where('transaction_id', $id)->get();
    }

    /**
     * Update an transaction.
     *
     * @param int   $id
     * @param array $payload
     *
     * @return Transaction
     */
    public function update($id, $payload)
    {
        $transaction = $this->find($id);

        return $this->repo->update($transaction, $payload);
    }

    /**
     * Refund a transaction.
     *
     * @param string $uuid
     *
     * @return bool
     */
    public function refund($uuid)
    {
        $transaction = $this->repo->findByUUID($uuid);

        if (app(StripeService::class)->refund($transaction->provider_id)) {
            $transaction->update([
                'refund_date' => Carbon::now(),
            ]);
            app(LogisticService::class)->afterRefund($transaction);

            return true;
        }

        return false;
    }
}
