<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Yab\Quazar\Services\StripeService;

class StripeServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $stripe = Mockery::mock(\Stripe\Stripe::class);
        $plan = Mockery::mock(\Stripe\Plan::class);
        $refund = Mockery::mock(\Stripe\Refund::class);

        $planObject = Mockery::mock('StdClass');
        $planObject->shouldReceive('delete')->andReturn(true);

        $stripe->shouldReceive('setApiKey')->andReturn(true);
        $plan->shouldReceive('all')->andReturn([]);
        $plan->shouldReceive('create')->andReturn(true);
        $plan->shouldReceive('retrieve')->andReturn($planObject);
        $plan->shouldReceive('create')->andReturn(true);

        $refund->shouldReceive('create')->with(['charge' => 999])->andReturn(true);

        $this->service = new StripeService($stripe, $plan, $refund);
    }

    public function testGetStripePlans()
    {
        $response = $this->service->collectStripePlans();
        $this->assertEquals($response, []);
    }

    public function testCreatePlan()
    {
        $response = $this->service->createPlan([
            'amount' => 99,
            'interval' => 'month',
            'name' => 'Wayne Gretzky',
            'currency' => 'cad',
            'descriptor' => 'Hockey',
            'trial_days' => 99,
            'stripe_id' => 'wayne-gretzky',
        ]);

        $this->assertEquals($response, true);
    }

    public function testDeletePlan()
    {
        $response = $this->service->deletePlan('wayne-gretzky');
        $this->assertEquals($response, true);
    }

    public function testRefund()
    {
        $response = $this->service->refund(999);
        $this->assertEquals($response, true);
    }
}
