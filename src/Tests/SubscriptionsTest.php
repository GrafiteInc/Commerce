<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class SubscriptionsTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->login('admin');
        $this->migrateUp('quarx');
        factory(\Quarx\Modules\Hadron\Models\SubscriptionPlans::class)->create();
        factory(\Quarx\Modules\Hadron\Models\SubscriptionPlans::class)->make();
    }

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */

    public function testIndex()
    {
        $response = $this->call('GET', '/quarx/subscriptions');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('subscriptions');
    }

    public function testCreate()
    {
        $response = $this->call('GET', '/quarx/subscriptions/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEdit()
    {
        $response = $this->call('GET', '/quarx/subscriptions/'.Crypto::encrypt(1).'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('subscriptions');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testStore()
    {
        $subscription = factory(\Quarx\Modules\Hadron\Models\SubscriptionPlans::class)->make([ 'id' => 2 ]);
        $response = $this->call('POST', '/quarx/subscriptions', $subscription['attributes']);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/quarx/subscriptions');
    }

    public function testUpdate()
    {
        $response = $this->call('PATCH', '/quarx/subscriptions/'.Crypto::encrypt(1), [
            'name' => 'awesome plan!',
            'price' => 9.99,
            'provider_id' => 'z879as87d89a',
            'interval' => 'monthly',
            'statement_desc' => 'something',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/quarx/subscriptions/'.Crypto::encrypt(1).'/edit');
    }

    public function testDelete()
    {
        $response = $this->call('GET', '/quarx/subscriptions/'.Crypto::encrypt(1).'/delete');
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/quarx/subscriptions');
    }

}

