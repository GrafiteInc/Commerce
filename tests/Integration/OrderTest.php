<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

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

        factory(\Grafite\Commerce\Models\Cart::class)->create();
        factory(\Grafite\Commerce\Models\Product::class)->create();
        factory(\Grafite\Commerce\Models\Plan::class)->create();
        factory(\Grafite\Commerce\Models\Order::class)->create();
        factory(\Grafite\Commerce\Models\Transaction::class)->create([
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
        $response = $this->call('GET', 'cms/orders');
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('orders');
        $response->assertSee('Orders');
    }

    public function testEdit()
    {
        factory(\Grafite\Commerce\Models\Order::class)->create([
            'id' => 2,
            'details' => json_encode([
                [
                    'price' => 10900,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);
        $response = $this->call('GET', 'cms/orders/2/edit');

        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('order');
        $response->assertSee('#');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testSearch()
    {
        $response = $this->call('POST', 'cms/orders/search', ['term' => 'wtf']);

        $response->assertViewHas('orders');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        factory(\Grafite\Commerce\Models\Order::class)->create([
            'id' => 4,
            'details' => json_encode([
                [
                    'price' => 100,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);

        $response = $this->call('PATCH', 'cms/orders/4', [
            'details' => json_encode([
                [
                    'price' => 10900,
                    'quantity' => 1,
                    'name' => 'foobar',
                ],
            ]),
        ]);

        $this->assertDatabaseHas('orders', ['details' => '[{"price":10900,"quantity":1,"name":"foobar"}]']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'cms/orders/1');
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testCreate()
    {
        $response = $this->call('get', 'cms/orders/create');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
