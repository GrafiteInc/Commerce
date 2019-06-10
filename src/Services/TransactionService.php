<?php

namespace SierraTecnologia\Commerce\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use SierraTecnologia\Commerce\Models\Order;
use SierraTecnologia\Commerce\Repositories\TransactionRepository;

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
    public function overMonths($months = 1)
    {
        return $this->repo->overMonths($months);
    }

    /**
     * Get all Orders.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated()
    {
        return $this->repo->paginated(config('cms.pagination', 25));
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
        return $this->repo->search($payload, config('cms.pagination', 25));
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
        return app(Order::class)->where('transaction_id', $id)->first();
    }

    /**
     * Create an transaction.
     *
     * @param array $payload
     *
     * @return Transaction
     */
    public function create($payload)
    {
        $payload['tax'] = $payload['tax'] * 100;
        $payload['shipping'] = $payload['shipping'] * 100;
        $payload['subtotal'] = $payload['subtotal'] * 100;
        $payload['total'] = $payload['total'] * 100;

        return $this->repo->store($payload);
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
    public function refund($uuid, $amount = null)
    {
        $transaction = $this->repo->findByUUID($uuid);

        $refund = app(StripeService::class)->refund($transaction->provider_id, $amount);

        if ($refund) {
            $transaction->update([
                'refund_date' => Carbon::now(),
            ]);

            app(LogisticService::class)->afterRefund($transaction);

            return $refund;
        }

        return false;
    }
}
