<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class StoreTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->login();
        $this->migrateUp('quarx');
    }

    /*
    |--------------------------------------------------------------------------
    | Views
    |--------------------------------------------------------------------------
    */

    public function testContents()
    {
        $response = $this->call('GET', '/store/');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertViewHas('products');
    }

}

