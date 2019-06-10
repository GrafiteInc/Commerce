<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class TransactionTest extends TestCase
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

        factory(\SierraTecnologia\Commerce\Models\Cart::class)->create();
        factory(\SierraTecnologia\Commerce\Models\Product::class)->create([
            'id' => 1,
        ]);
        factory(\SierraTecnologia\Commerce\Models\Plan::class)->create();
        factory(\SierraTecnologia\Commerce\Models\Transaction::class)->create();
        factory(\SierraTecnologia\Commerce\Models\Transaction::class)->create([
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
        $response = $this->call('GET', 'cms/transactions');
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('transactions');
        $response->assertSee('Transactions');
    }

    public function testEdit()
    {
        factory(\SierraTecnologia\Commerce\Models\Order::class)->create([
            'transaction_id' => 2,
        ]);

        factory(\SierraTecnologia\Commerce\Models\Transaction::class)->create([
            'id' => 2,
            'notes' => 'Le notes!',
        ]);
        $response = $this->call('GET', 'cms/transactions/2/edit');

        $this->assertEquals(200, $response->getStatusCode());
        $response->assertViewHas('transaction');
        $response->assertSee('#');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testSearch()
    {
        $response = $this->call('POST', 'cms/transactions/search', ['term' => 'wtf']);

        $response->assertViewHas('transactions');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        factory(\SierraTecnologia\Commerce\Models\Transaction::class)->create([
            'id' => 4,
            'notes' => 'Star Wars !',
        ]);

        $response = $this->call('PATCH', 'cms/transactions/4', [
            'notes' => 'nada',
        ]);

        $this->assertDatabaseHas('transactions', ['notes' => 'nada']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'cms/transactions/1');
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testCreate()
    {
        $response = $this->call('get', 'cms/transactions/create');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
