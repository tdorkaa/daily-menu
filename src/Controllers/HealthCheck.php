<?php

namespace DailyMenu\Controllers;

use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheck
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function healthCheck(Request $request, Response $response, array $args)
    {
        $this->pdo->query('SELECT 1');
        $response->getBody()->write("OK");
        return $response;
    }
}