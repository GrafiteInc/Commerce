<?php

class OrderTest extends TestCase
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

        factory(\Yab\Quazar\Models\Cart::class)->create();
        factory(\Yab\Quazar\Models\Product::class)->create();
        factory(\Yab\Quazar\Models\Plan::class)->create();
        factory(\Yab\Quazar\Models\Orders::class)->create();
        factory(\Yab\Quazar\Models\Transactions::class)->create([
                'id' => 999,
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */

    public function testIndex()
    {
        $response = $this->call('GET', 'quarx/orders');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('orders');
        $this->see('Orders');
    }

    // public function testCreate()
    // {
    //     $response = $this->call('GET', 'quarx/orders/create');
    //     $this->assertEquals(200, $response->getStatusCode());
    //     $this->see('Title');
    // }

    public function testEdit()
    {
        factory(\Yab\Quazar\Models\Orders::class)->create([
            'id' => 2,
            'details' => json_encode([
                [
                    'price' => 10900,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);
        $response = $this->call('GET', 'quarx/orders/'.Crypto::encrypt(2).'/edit');

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
        $response = $this->call('POST', 'quarx/orders/search', ['term' => 'wtf']);

        $this->assertViewHas('orders');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        factory(\Yab\Quazar\Models\Orders::class)->create([
            'id' => 4,
            'details' => json_encode([
                [
                    'price' => 100,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);

        $response = $this->call('PATCH', 'quarx/orders/'.Crypto::encrypt(4), [
            'details' => json_encode([
                [
                    'price' => 10900,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);

        $this->seeInDatabase('orders', ['details' => '[{"price":10900,"quantity":1,"name":"foobar"}]']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'quarx/orders/'.Crypto::encrypt(1));
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testCreate()
    {
        $response = $this->call('get', 'quarx/orders/create');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
