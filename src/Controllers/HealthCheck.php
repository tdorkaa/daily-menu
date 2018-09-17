<?php

namespace DailyMenu\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheck
{
    public function healthCheck(Request $request, Response $response, array $args)
    {
        $response->getBody()->write("OK");
        return $response;
    }
}