<?php

namespace App\Http\Controllers\Commerce;

use App\Http\Controllers\Controller;
use Auth;
use Sitec\Commerce\Repositories\TransactionRepository;

class PurchaseController extends Controller
{
    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactions = $transactionRepo;
    }

    /**
     * List all customer purchases
     *
     * @return Illuminate\Http\Response
     */
    public function allPurchases()
    {
        $purchases = $this->transactions->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(config('cms.pagination'));

        return view('commerce-frontend::purchases.all')
            ->with('purchases', $purchases);
    }

    /**
     * View a customer purchase
     *
     * @return Illuminate\Http\Response
     */
    public function getPurchase($id)
    {
        $purchase = $this->transactions->getByCustomerAndUuid(auth()->id(), $id);

        return view('commerce-frontend::purchases.purchase')
            ->with('purchase', $purchase);
    }

    /**
     * Request a refund for a purchase
     *
     * @return Illuminate\Http\Response
     */
    public function requestRefund($id)
    {
        $purchase = $this->transactions->requestRefund(auth()->id(), $id);

        return view('commerce-frontend::purchases.refund');
    }
}
