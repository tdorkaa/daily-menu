<?php

namespace Tests\Controller;

use DailyMenu\Controllers\HealthCheck;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class HealthcheckTest extends TestCase
{
    /**
     * @test
     */
    public function healthcheck_makeAQueryToDb()
    {
        $mockPDO = $this->createMock(\PDO::class);
        $mockPDO->expects($this->once())
            ->method('query')
            ->with('SELECT 1');

        $healthCheck = new HealthCheck($mockPDO);
        $healthCheck->healthcheck($this->createMock(Request::class),
            new Response(), []);
    }
}