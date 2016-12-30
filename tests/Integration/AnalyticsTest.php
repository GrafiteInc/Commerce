<?php

class AnalyticsTest extends TestCase
{
    public function testAnalytics()
    {
        $this->withoutMiddleware();
        $response = $this->call('GET', '/quarx/commerce-analytics');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
