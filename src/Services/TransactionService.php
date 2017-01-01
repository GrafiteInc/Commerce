<?php

namespace Quarx\Modules\Hadron\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Quarx\Modules\Hadron\Models\Orders;
use Quarx\Modules\Hadron\Repositories\TransactionRepository;

class TransactionService
{
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->repo = $transactionRepository;
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function thisYear()
    {
        return $this->repo->thisYear();
    }

    public function paginated()
    {
        return $this->repo->paginated(Config::get('quarx.pagination', 25));
    }

    public function findTransactionsById($id)
    {
        return $this->repo->findTransactionsById($id);
    }

    public function search($payload)
    {
        return $this->repo->search($payload, Config::get('quarx.pagination', 25));
    }

    public function find($id)
    {
        return $this->repo->findTransactionsById($id);
    }

    public function getTransactionOrder($id)
    {
        return app(Orders::class)->where('transaction_id', $id)->get();
    }

    public function update($id, $payload)
    {
        $transaction = $this->find($id);

        return $this->repo->update($transaction, $payload);
    }

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
