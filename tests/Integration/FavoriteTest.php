<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
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

    public function testGetFavorites()
    {
        $response = $this->actor->call('GET', '/store/favorites');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($response->getData()->status, 'success');
    }

    public function testAdd()
    {
        $response = $this->actor->call('GET', '/store/favorites/add/1');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($response->getData()->status, 'success');
    }

    public function testRemove()
    {
        $response = $this->actor->call('GET', '/store/favorites/remove/1');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($response->getData()->status, 'success');
    }
}
