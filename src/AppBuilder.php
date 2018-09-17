<?php

namespace DailyMenu;

use DailyMenu\Controllers\HealthCheck;
use Slim\App;

class AppBuilder
{
    public static function build()
    {
        $app = new App;
        self::setUpRoutes($app);
        return $app;
    }

    private static function setUpRoutes($app)
    {
        $app->get('/healthcheck', HealthCheck::class . ':healthcheck');
    }
}