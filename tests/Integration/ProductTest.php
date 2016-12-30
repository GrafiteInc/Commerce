<?php

class ProductTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        factory(\Quarx\Modules\Hadron\Models\Product::class)->create();
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
        $this->see('Title');
    }

    public function testEdit()
    {
        factory(\Quarx\Modules\Hadron\Models\Product::class)->create(['id' => 4]);
        $response = $this->call('GET', 'quarx/products/4/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('product');
        $this->see('Title');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testStore()
    {
        $product = ['name' => 'dumber', 'url' => 'dumber', 'entry' => 'okie dokie', 'price' => 9.99];
        $response = $this->call('POST', 'quarx/products', $product);

        $this->seeInDatabase('products', ['id' => 2]);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testSearch()
    {
        $response = $this->call('POST', 'quarx/products/search', ['term' => 'wtf']);

        $this->assertViewHas('products');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $product = ['name' => 'dumber', 'url' => 'dumber', 'entry' => 'okie dokie', 'price' => 19.99];
        $this->call('POST', 'quarx/product', $product);

        $response = $this->call('PATCH', 'quarx/products/1', [
            'name' => 'dumber and dumber',
            'url' => 'dumber-and-dumber',
            'price' => 99.99,
        ]);

        $this->seeInDatabase('products', ['name' => 'dumber and dumber']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'quarx/products/1');
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('quarx/products');
    }
}
