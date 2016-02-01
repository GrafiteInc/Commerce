<?php

namespace Yab\Store\Services\PaymentServices;

use URL;
use ShoppingCart;
use StoreHelper;
use Shipping;
use Module;
use Omnipay\Omnipay;
use Yab\Store\Models\Transactions;
use Yab\Store\Interfaces\PaymentInterface;

class PayPal implements PaymentInterface
{
    public function __construct($platform)
    {
        $this->gateway = Omnipay::create('PayPal_Express');

        $this->storePayPalConfig = StoreHelper::getConfig('paypal');

        $paypalCancelledURL = $this->storePayPalConfig['cancelled_url'];
        $paypalSuccessURL = $this->storePayPalConfig['success_url'];

        $this->cancelled_url = ( ! empty($paypalCancelledURL)) ? $paypalCancelledURL : URL::to('api/store-callback/cancelled/paypal/'.$platform);
        $this->success_url = ( ! empty($paypalSuccessURL)) ? $paypalSuccessURL : URL::to('api/store-callback/success/paypal/'.$platform);

        $this->gateway->setUsername($this->storePayPalConfig['paypal_username']);
        $this->gateway->setPassword($this->storePayPalConfig['paypal_password']);
        $this->gateway->setSignature($this->storePayPalConfig['paypal_signature']);
        $this->gateway->setTestMode($this->storePayPalConfig['paypal_testmode']);

        $this->cart = new ShoppingCart();
    }

    public function purchase($user, $request)
    {
        $shipping   = Shipping::rate($user);
        $subtotal   = $this->cart->getCartSubtotal($user);
        $total      = $this->cart->getCartTotal($user);

        $response = $this->gateway->purchase(array(
            'cancelUrl'     => $this->cancelled_url,
            'returnUrl'     => $this->success_url,
            'amount'        => $total,
            'currency'      => strtoupper(StoreHelper::getConfig('currency')),
            'Description'   => Module::config('store.config.store_name').' Purchase for '.$total
        ))->send();

        return $response->getRedirectUrl();
    }

    public static function cancelled()
    {
        return "Transaction has been cancelled";
    }

    public function success($user)
    {
        $response = $this->gateway->completePurchase(array(
            'amount'        => $this->cart->getCartTotal($user),
            'currency'      => strtoupper(StoreHelper::getConfig('currency')),
        ))->send();

        $paypalData = $response->getData();

        $transactionData['id']          = $paypalData["PAYMENTINFO_0_TRANSACTIONID"];
        $transactionData['created']     = $paypalData["PAYMENTINFO_0_ORDERTIME"];
        $transactionData['dispute']     = null;
        $transactionData['subtotal']    = $this->cart->getCartSubtotal($user);
        $transactionData['total']       = $this->cart->getCartTotal($user);
        $transactionData['shipping']    = Shipping::rate($user);
        $transactionData['user']        = $user;

        if (Transactions::saveTransaction($transactionData, 'paypal')) {
            $this->cart->emptyShoppingCart($user->id);
            return redirect($this->storePayPalConfig['return_url']);
        }

        throw new \Exception("Error Processing Payment", 1);
    }

    public function refund($user, $transaction)
    {
        $response = $this->gateway->refund(array(
            'transactionReference' => $transaction->vendor_id,
        ))->send();

        $paypalData = $response->getData();

        if ($paypalData['ACK'] === 'Success') {
            Transactions::refundTransaction($transaction->id, json_encode($paypalData));
            return $paypalData['REFUNDTRANSACTIONID'];
        }

        return false;
    }

}