<?php
namespace Tests\WebTestCase;

use PHPUnit\Framework\TestCase;

class HealtcheckTest extends TestCase
{
    use Webtestcase;

    /**
     * @test
     */
    public function call_Healthcheck_Returns200()
    {
        $response = $this->processRequest('GET', '/healthcheck');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', (String)$response->getBody());
    }
}