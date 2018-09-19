<?php

namespace Tests\WebTestCase;

use DailyMenu\AppBuilder;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

trait Webtestcase {

    public function processRequest($method, $url, $requestBody = null)
    {
        $app = AppBuilder::build();
        $request = Request::createFromEnvironment(
            Environment::mock([
                'REQUEST_METHOD' => $method,
                'REQUEST_URI' => $url
            ])
        );
        if ($requestBody) {
            $request = $request->withParsedBody($requestBody);
        }

        return $app->process($request, new Response());
    }

}