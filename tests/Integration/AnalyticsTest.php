<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnalyticsTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnalytics()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/cms/commerce-analytics');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
