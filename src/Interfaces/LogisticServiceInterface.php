<?php

namespace SierraTecnologia\Commerce\Interfaces;

interface LogisticServiceInterface
{
    public function shipping($user);
    public function singleItemShipping($item, $user);
    public function getTaxPercent($user);
    public function afterPurchase($user, $transaction, $cart, $result);
    public function afterSubscription($user, $plan);
    public function afterRefundRequest($transaction);
    public function afterRefund($transaction);
    public function cancelSubscription($user, $plan);
    public function afterPlaceOrder($user, $transaction, $cart);
    public function orderCreated($order);
    public function shipOrder($order);
    public function cancelOrder($order);
    public function afterItemCancelled($orderItem);
}
