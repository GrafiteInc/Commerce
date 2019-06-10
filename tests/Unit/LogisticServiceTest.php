<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use SierraTecnologia\Commerce\Services\LogisticService;

class LogisticServiceTest extends TestCase
{
    use DatabaseMigrations;

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

    public function testCartWeight()
    {
        $result = $this->service->cartWeight();
        $this->assertEquals(0, $result);
    }

    public function testShipping()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;

        Auth::shouldReceive('user')->andReturn($user);

        $result = $this->service->shipping($user);
        $this->assertTrue($result);
    }

    public function testTaxPercent()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;

        Auth::shouldReceive('user')->andReturn($user);

        $result = $this->service->getTaxPercent($user);

        $this->assertTrue($result);
    }

    public function testAfterPurchase()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        Auth::shouldReceive('user')->andReturn($user);
        $transaction = Mockery::mock('StdClass');
        $cart = Mockery::mock('StdClass');
        $result = Mockery::mock('StdClass');

        $result = $this->service->afterPurchase($user, $transaction, $cart, $result);

        $this->assertTrue($result);
    }

    public function testAferSubscription()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        Auth::shouldReceive('user')->andReturn($user);
        $plan = 'default';

        $result = $this->service->afterSubscription($user, $plan);
        $this->assertTrue($result);
    }

    public function testRefundRequest()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        Auth::shouldReceive('user')->andReturn($user);
        $transaction = Mockery::mock('StdClass');

        $result = $this->service->afterRefundRequest($transaction);

        $this->assertTrue($result);
    }

    public function testAfterRefund()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        Auth::shouldReceive('user')->andReturn($user);
        $transaction = Mockery::mock('StdClass');

        $result = $this->service->afterRefund($transaction);
        $this->assertTrue($result);
    }

    public function testCancelSubscription()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        Auth::shouldReceive('user')->andReturn($user);
        $plan = 'default';

        $result = $this->service->cancelSubscription($user, $plan);
        $this->assertTrue($result);
    }

    public function testAfterPlaceOrder()
    {
        $user = Mockery::mock('StdClass');
        $user->id = 1;
        Auth::shouldReceive('user')->andReturn($user);
        $transaction = Mockery::mock('StdClass');
        $cart = Mockery::mock('StdClass');

        $result = $this->service->afterPlaceOrder($user, $transaction, $cart);
        $this->assertTrue($result);
    }

    public function testOrderCreated()
    {
        $order = Mockery::mock('StdClass');

        $result = $this->service->orderCreated($order);
        $this->assertTrue($result);
    }

    public function testShipOrder()
    {
        $order = Mockery::mock('StdClass');

        $result = $this->service->shipOrder($order);
        $this->assertTrue($result);
    }

    public function testCancelOrder()
    {
        $order = Mockery::mock('StdClass');

        $result = $this->service->cancelOrder($order);

        $this->assertTrue($result);
    }
}
