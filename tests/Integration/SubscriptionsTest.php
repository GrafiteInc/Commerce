<?php

class SubscriptionsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\Models\User::class)->create([
            'id' => 1,
        ]);
        $this->role = factory(App\Models\Role::class)->create([
            'name' => 'admin',
        ]);

        $this->user->roles()->attach($this->role);
        $this->actingAs($this->user);

        factory(\Quarx\Modules\Hadron\Models\Cart::class)->create();
        factory(\Quarx\Modules\Hadron\Models\Product::class)->create();
        factory(\Quarx\Modules\Hadron\Models\Plan::class)->create();
    }

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */

    public function testIndex()
    {
        $response = $this->call('GET', 'quarx/plans');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('plans');
        $this->see('Orders');
    }

    // public function testCreate()
    // {
    //     $response = $this->call('GET', 'quarx/plans/create');
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $this->see('Title');
    // }

    public function testEdit()
    {
        factory(\Quarx\Modules\Hadron\Models\Orders::class)->create([
            'id' => 2,
            'details' => json_encode([
                [
                    'price' => 10900,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);
        $response = $this->call('GET', 'quarx/plans/'.Crypto::encrypt(2).'/edit');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('order');
        $this->see('#');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testSearch()
    {
        $response = $this->call('POST', 'quarx/plans/search', ['term' => 'wtf']);

        $this->assertViewHas('plans');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        factory(\Quarx\Modules\Hadron\Models\Orders::class)->create([
            'id' => 4,
            'details' => json_encode([
                [
                    'price' => 100,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);

        $response = $this->call('PATCH', 'quarx/plans/'.Crypto::encrypt(4), [
            'details' => json_encode([
                [
                    'price' => 10900,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);

        $this->seeInDatabase('plans', ['details' => '[{"price":10900,"quantity":1,"name":"foobar"}]']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'quarx/plans/'.Crypto::encrypt(1));
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testCreate()
    {
        $response = $this->call('get', 'quarx/plans/create');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
