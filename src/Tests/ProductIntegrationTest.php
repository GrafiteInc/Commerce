<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductIntegrationTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->product = factory(App\Repositories\Product\Product::class)->make([
            // put fields here
        ]);
        $this->productEdited = factory(App\Repositories\Product\Product::class)->make([
            // put fields here
        ]);
        $user = factory(App\Repositories\User\User::class)->make();
        $this->actor = $this->actingAs($user);
    }

    public function testIndex()
    {
        $response = $this->actor->call('GET', '/products');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('products');
    }

    public function testCreate()
    {
        $response = $this->actor->call('GET', '/products/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->actor->call('POST', 'products', $this->product->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('products/'.$this->product->id.'/edit');
    }

    public function testEdit()
    {
        $this->actor->call('POST', 'products', $this->product->toArray());

        $response = $this->actor->call('GET', '/products/'.$this->product->id.'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('product');
    }

    public function testUpdate()
    {
        $this->actor->call('POST', 'products', $this->product->toArray());
        $response = $this->actor->call('PATCH', '/products/1', $this->productEdited->toArray());

        $this->assertEquals(302, $response->getStatusCode());
        $this->seeInDatabase('products', $this->productEdited->toArray());
        $this->assertRedirectedTo('/');
    }

    public function testDelete()
    {
        $this->actor->call('POST', 'products', $this->product->toArray());

        $response = $this->call('GET', '/products/'.$this->product->id.'/delete');
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/products');
    }

}
