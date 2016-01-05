<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductsTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->login('admin');
        $this->migrateUp('quarx');

        factory(\Mlantz\Hadron\Models\Products::class)->create();
    }

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */

    public function testIndex()
    {
        $response = $this->call('GET', 'quarx/products');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('products');
    }

    public function testCreate()
    {
        $response = $this->call('GET', 'quarx/products/create');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testEdit()
    {
        $response = $this->call('GET', 'quarx/products/'.Crypto::encrypt(1).'/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('products');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testStore()
    {
        $products = (array) factory(\Mlantz\Hadron\Models\Products::class)->make([ 'id' => 2 ]);
        $response = $this->call('POST', 'quarx/products', $products);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/');
    }

    public function testUpdate()
    {
        $products = (array) factory(\Mlantz\Hadron\Models\Products::class)->make([ 'id' => 3, 'name' => 'dumber' ]);
        $response = $this->call('PATCH', 'quarx/products/'.Crypto::encrypt(3), $products);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/');
    }

    public function testDelete()
    {
        $response = $this->call('GET', 'quarx/products/'.Crypto::encrypt(1).'/delete');
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('quarx/products');
    }

}

