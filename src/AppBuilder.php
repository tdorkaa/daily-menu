<?php

namespace DailyMenu;

use DailyMenu\Controllers\HealthCheck;
use PDO;
use Slim\App;

class AppBuilder
{
    public static function build()
    {
        $app = new App;
        $container = $app->getContainer();
        self::setUpRoutes($app);
        self::setUpDb($container);
        self::setUpDependencies($container);
        return $app;
    }

    private static function setUpRoutes($app)
    {
        $app->get('/healthcheck', HealthCheck::class . ':healthcheck');
    }

    private static function setUpDb($container)
    {
        $container['pdo'] = function () {
            return new PDO("mysql:host=mysql;charset=utf8mb4", 'academy', 'academy', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        };
        return $container;
    }

    private static function setUpDependencies($container)
    {
        $container[HealthCheck::class] = function ($container) {
            return new HealthCheck(
                $container['pdo']
            );
        };
    }

}