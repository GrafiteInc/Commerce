<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
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

        factory(\SierraTecnologia\Commerce\Models\Product::class)->create();
    }

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */

    public function testIndex()
    {
        $response = $this->call('GET', 'cms/products');
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('products');
    }

    public function testCreate()
    {
        $response = $this->call('GET', 'cms/products/create');
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertSee('Name');
    }

    public function testEdit()
    {
        factory(\SierraTecnologia\Commerce\Models\Product::class)->create(['id' => 4]);
        $response = $this->call('GET', 'cms/products/4/edit');
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('product');
        $response->assertSee('Name');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testStore()
    {
        $product = ['name' => 'dumber', 'url' => 'dumber', 'entry' => 'okie dokie', 'price' => 9.99];
        $response = $this->call('POST', 'cms/products', $product);

        $this->assertDatabaseHas('products', ['id' => 2]);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testSearch()
    {
        $response = $this->call('POST', 'cms/products/search', ['term' => 'wtf']);

        $response->assertViewHas('products');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $product = ['name' => 'dumber', 'url' => 'dumber', 'entry' => 'okie dokie', 'price' => 19.99];
        $this->call('POST', 'cms/product', $product);

        $response = $this->call('PATCH', 'cms/products/1', [
            'name' => 'dumber and dumber',
            'url' => 'dumber-and-dumber',
            'price' => 99.99,
        ]);

        $this->assertDatabaseHas('products', ['name' => 'dumber and dumber']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'cms/products/1');
        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect('cms/products');
    }
}
