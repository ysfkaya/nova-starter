<?php

namespace Tightenco\NovaGoogleAnalytics\Tests;

use Tightenco\NovaGoogleAnalytics\Http\Controllers\ToolController;
use Tightenco\NovaGoogleAnalytics\NovaGoogleAnalytics;
use Symfony\Component\HttpFoundation\Response;

class ToolControllerTest extends TestCase
{
    /** @test */
    public function it_can_can_return_a_response()
    {
        $this
            ->get('nova-vendor/tightenco/nova-google-analytics/endpoint')
            ->assertSuccessful();
    }
}
