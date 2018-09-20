<?php

namespace DailyMenu;

use DailyMenu\Controllers\DailyMenu;
use DailyMenu\Controllers\HealthCheck;
use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class AppBuilder
{
    public static function build()
    {
        $envLoader = new EnvLoader();
        $envLoader->loadEnvVars();

        $app = new App(new Container([
            'settings' => [
                'displayErrorDetails' => true
            ]]));
        $container = $app->getContainer();
        self::setUpRoutes($app);
        self::setUpDb($container);
        self::setUpDependencies($container);
        self::setUpTwig($container);
        return $app;
    }

    private static function setUpRoutes($app)
    {
        $app->get('/healthcheck', HealthCheck::class . ':healthcheck');
        $app->get('/dailymenus', DailyMenu::class . ':getDailyMenus');
    }

    private static function setUpDb($container)
    {
        $container['pdo'] = function () {
            return (new PdoFactory())->getPdo();
        };
        return $container;
    }

    private static function setUpTwig($container)
    {
        $container['view'] = function ($container) {
            $view = new Twig(__DIR__ . '/../view', [
                'cache' => false
            ]);

            // Instantiate and add Slim specific extension
            $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
            $view->addExtension(new TwigExtension($container->get('router'), $basePath));

            return $view;
        };
    }

    private static function setUpDependencies($container)
    {
        $container[HealthCheck::class] = function ($container) {
            return new HealthCheck(
                $container['pdo']
            );
        };

        $container[DailyMenu::class] = function ($container) {
            return new DailyMenu(
                $container['view'],
                new DailyMenuDao($container['pdo'])
            );
        };
    }

}