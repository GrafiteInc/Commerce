<?php

namespace App\Http\Controllers\Quazar;

use App\Http\Controllers\Controller;
use Auth;
use Yab\Quazar\Repositories\TransactionRepository;
use Yab\Crypto\Services\Crypto;

class PurchaseController extends Controller
{
    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactions = $transactionRepo;
    }

    public function allPurchases()
    {
        $purchases = $this->transactions->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(config('quarx.pagination'));

        return view('quazar-frontend::purchases.all')
            ->with('purchases', $purchases);
    }

    public function getPurchase($id)
    {
        $purchase = $this->transactions->getByCustomerAndId(auth()->id(), Crypto::decrypt($id));

        return view('quazar-frontend::purchases.purchase')
            ->with('purchase', $purchase);
    }

    public function requestRefund($id)
    {
        $purchase = $this->transactions->requestRefund(Crypto::decrypt($id));

        return view('quazar-frontend::purchases.refund');
    }
}
