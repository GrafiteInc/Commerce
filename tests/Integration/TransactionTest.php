<?php

class TransactionTest extends TestCase
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
        factory(\Yab\Quazar\Models\Product::class)->create([
            'id' => 1,
        ]);
        factory(\Yab\Quazar\Models\Plan::class)->create();
        factory(\Yab\Quazar\Models\Transactions::class)->create();
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
        $response = $this->call('GET', 'quarx/transactions');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('transactions');
        $this->see('Transactions');
    }

    public function testEdit()
    {
        factory(\Yab\Quazar\Models\Transactions::class)->create([
            'id' => 2,
            'notes' => 'Le notes!',
        ]);
        $response = $this->call('GET', 'quarx/transactions/2/edit');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('transaction');
        $this->see('#');
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    public function testSearch()
    {
        $response = $this->call('POST', 'quarx/transactions/search', ['term' => 'wtf']);

        $this->assertViewHas('transactions');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        factory(\Yab\Quazar\Models\Transactions::class)->create([
            'id' => 4,
            'notes' => 'Star Wars !',
        ]);

        $response = $this->call('PATCH', 'quarx/transactions/4', [
            'notes' => 'nada',
        ]);

        $this->seeInDatabase('transactions', ['notes' => 'nada']);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->call('DELETE', 'quarx/transactions/1');
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testCreate()
    {
        $response = $this->call('get', 'quarx/transactions/create');
        $this->assertEquals(405, $response->getStatusCode());
    }
}
