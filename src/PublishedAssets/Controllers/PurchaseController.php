<?php

namespace App\Http\Controllers\Hadron;

use Auth;
use Quarx;
use Request;
use Redirect;
use App\Http\Controllers\Controller;
use Yab\Hadron\Repositories\TransactionRepository;

class PurchaseController extends Controller
{

    function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactions = $transactionRepo;
    }

    public function allPurchases()
    {
        $purchases = $this->transactions->getByCustomer(Auth::id())->orderBy('created_at', 'DESC')->paginate(env('PAGINATION'));
        return view('hadron-frontend::purchases.all')->with('purchases', $purchases);
    }

    public function getPurchase($id)
    {
        $purchase = $this->transactions->getByCustomerAndId(Auth::id(), $id);
        return view('hadron-frontend::purchases.purchase')->with('purchase', $purchase);
    }

    public function requestRefund($id)
    {

    }

}
