<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Library\Services\ReportClient;
use Illuminate\Http\Response;

class ReportClientTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new ReportClient();
    }

    /**
     * Testing mocked response
     */
    public function testLatestUpdate()
    {

        $response = $this->client->request('GET', "/");

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertStringContainsString('Costa Rica', (string) $response->getBody());
    }
}