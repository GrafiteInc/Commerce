<?php

use Quarx\Modules\Hadron\Services\LogisticService;

class LogisticServiceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $storeLogicMock = Mockery::mock('App\Services\StoreLogistics');
        $storeLogicMock->shouldReceive('shipping')->with(Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('getTaxPercent')->with(Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('afterPurchase')
        ->with(Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any())
        ->andReturn(true);
        $storeLogicMock->shouldReceive('afterSubscription')->with(Mockery::any(), Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('afterRefundRequest')->with(Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('afterRefund')->with(Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('cancelSubscription')->with(Mockery::any(), Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('afterPlaceOrder')
        ->with(Mockery::any(), Mockery::any(), Mockery::any())
        ->andReturn(true);
        $storeLogicMock->shouldReceive('orderCreated')->with(Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('shipOrder')->with(Mockery::any())->andReturn(true);
        $storeLogicMock->shouldReceive('cancelOrder')->with(Mockery::any())->andReturn(true);

        $this->app->instance('App\Services\StoreLogistics', $storeLogicMock);

        $this->service = app(LogisticService::class);
    }

    public function test()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        $transaction = Mockery::mock('StdClass');
        $cart = Mockery::mock('StdClass');
        $result = Mockery::mock('StdClass');
        $order = Mockery::mock('StdClass');
        $plan = 'default';

        Auth::shouldReceive('user')->andReturn($user);

        $this->service->cartWeight();
        $this->service->shipping($user);
        $this->service->getTaxPercent($user);
        $this->service->afterPurchase($user, $transaction, $cart, $result);
        $this->service->afterSubscription($user, $plan);
        $this->service->afterRefundRequest($transaction);
        $this->service->afterRefund($transaction);
        $this->service->cancelSubscription($user, $plan);
        $this->service->afterPlaceOrder($user, $transaction, $cart);
        $this->service->orderCreated($order);
        $this->service->shipOrder($order);
        $this->service->cancelOrder($order);
    }
}
