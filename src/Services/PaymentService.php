<?php

namespace Mlantz\Hadron\Services;

use Auth;
use Session;
use Logistics;
use ShoppingCart;
use Mlantz\Hadron\Models\Transactions;

class PaymentService
{
    protected $account;
    protected $user;
    protected $gateway;

    public function __construct($gateway, $platform)
    {
        $this->user                 = Auth::user();
        $PaymentServiceGateway      = PaymentService::gateway($gateway);
        $this->gateway              = new $PaymentServiceGateway($platform);
        $this->cart                 = new ShoppingCart;
    }

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    public function initiatePurchase($request)
    {
        return $this->gateway->purchase($this->user, $request->data);
    }

    public function success()
    {
        Logistics::setOrder($this->cart->getShoppingCart());

        $result = $this->gateway->success($this->user);

        return $result;
    }

    public function cancelled()
    {
        $result = $this->gateway->cancelled($this->user);

        Logistics::cancelOrder($result);

        return $result;
    }

    public function refundPurchase($transaction)
    {
        $refundData = $this->gateway->refund($this->user, $transaction);

        Logistics::refundOrder($refundData);

        if ( ! $refundData) {
            return array('status' => 'error', 'data' => Module::lang('store.notifications.payment.refund-fail'));
        } else {
            return array('status' => 'success', 'data' => $refundData);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    private static function gateway($gateway)
    {
        $paymentGatewayName = ucfirst($gateway);
        $paymentGateway = 'Mlantz\Store\Services\PaymentServices\\'.$paymentGatewayName;
        return $paymentGateway;
    }
}