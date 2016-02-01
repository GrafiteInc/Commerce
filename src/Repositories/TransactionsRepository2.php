<?php

namespace Yab\Store\Models;

use DB;
use Schema;
use Session;
use StoreHelper;
use ShoppingCart;
use Illuminate\Database\Schema\Blueprint as Blueprint;
use Yab\Store\Models\ServiceModels\BaseModel;

class Transactions extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->connection   = StoreHelper::getDatabaseName();
        $this->table        = StoreHelper::getConfig('transactions_table');
        $this->primaryKey   = StoreHelper::getConfig('transactions_key');

        if ( ! Schema::connection($this->connection)->hasTable($this->table)) {
            Schema::connection($this->connection)->create($this->table, function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('platform');

                $table->string('gateway');
                $table->string('vendor_id');
                $table->datetime('vendor_created');
                $table->string('vendor_dispute')->nullable();

                $table->text('products');
                $table->string('subtotal');
                $table->string('total');
                $table->string('shipping');

                $table->string('status');
                $table->text('refund');

                $table->datetime('updated_at');
                $table->datetime('created_at');
            });
        }
    }

    public static function getTransactionByID($id)
    {
        return Transactions::findOrFail($id);
    }

    public static function getTransactionByVendorID($id, $userID)
    {
        return Transactions::where('vendor_id', '=', $id)->where('user_id', '=', $userID)->firstOrFail();
    }

    public static function getSingleTransaction($user, $id)
    {
        return Transactions::where('id', $id)->where('user_id', $user->id)->get();
    }

    public static function getAllTransactions($user)
    {
        return Transactions::where('user_id', $user->id)->get();
    }

    public static function saveTransaction($transactionData, $gateway)
    {
        $cart = new ShoppingCart;
        $transaction = new Transactions;

        $user   = $transactionData['user'];

        $transaction->user_id           = $user->id;
        $transaction->platform          = Session::get('platform');
        $transaction->gateway           = $gateway;
        $transaction->vendor_id         = $transactionData['id'];
        $transaction->vendor_created    = $transactionData['created'];
        $transaction->vendor_dispute    = $transactionData['dispute'];
        $transaction->products          = json_encode($cart->getShoppingCart($user));
        $transaction->subtotal          = $transactionData['subtotal'];
        $transaction->total             = $transactionData['total'];
        $transaction->shipping          = $transactionData['shipping'];
        $transaction->status            = 'purchased';

        return $transaction->save();
    }

    public static function refundTransaction($transactionID, $refundInfo)
    {
        $transaction = Transactions::getTransactionByID($transactionID);

        $transaction->status            = 'refunded';
        $transaction->refund            = $refundInfo;

        return $transaction->save();
    }

}