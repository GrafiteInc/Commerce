<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

require __DIR__.'/../../fixture/Models/User.php';
require __DIR__.'/../../fixture/Models/Role.php';

class CartTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\Models\User::class)->create([
            'id' => rand(1000, 9999),
        ]);
        $this->role = factory(App\Models\Role::class)->create([
            'name' => 'admin',
        ]);

        $this->user->roles()->attach($this->role);
        $this->actor = $this->actingAs($this->user);

        factory(\Sitec\Commerce\Models\Cart::class)->create();
        factory(\Sitec\Commerce\Models\Product::class)->create();
        factory(\Sitec\Commerce\Models\Plan::class)->create();
    }

    public function testContents()
    {
        $response = $this->call('GET', '/store/cart/contents');

        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('products');
    }

    public function testEmpty()
    {
        $response = $this->call('GET', '/store/cart/empty');
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('/');
    }

    public function testAddProduct()
    {
        $response = $this->call('GET', '/store/cart/add?id=1&type=product&quantity=1&variants=%7B%7D');
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent());
        $this->assertEquals('success', $decoded->status);
        $this->assertEquals('Added to Cart', $decoded->data);
    }

    public function testAddSubscription()
    {
        $response = $this->call('GET', '/store/cart/add?id=1&type=subscription&quantity=1&variants=%7B%7D');
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent());
        $this->assertEquals('success', $decoded->status);
        $this->assertEquals('Added to Cart', $decoded->data);
    }

    public function testCartCount()
    {
        $response = $this->call('GET', '/store/cart/count');
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent());
        $this->assertEquals('success', $decoded->status);
        $this->assertEquals('0', $decoded->data);
    }

    public function testRemove()
    {
        // First add
        $this->call('GET', '/store/cart/add?id=1&type=subscription&quantity=1&variants=%7B%7D');
        // Then remove
        $response = $this->call('GET', '/store/cart/remove?id=2&type=subscription');
        $this->assertEquals(200, $response->getStatusCode());
        $decoded = json_decode($response->getContent());
        $this->assertEquals('success', $decoded->status);
    }
}
