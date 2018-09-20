<?php

namespace DailyMenu\Controllers;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class DailyMenu
{
    /**
     * @var Twig
     */
    private $twig;
    /**
     * @var DailyMenuDao
     */
    private $dailyMenuDao;

    public function __construct(Twig $twig, DailyMenuDao $dailyMenuDao)
    {
        $this->twig = $twig;
        $this->dailyMenuDao = $dailyMenuDao;
    }

    public function getDailyMenus(Request $request, Response $response, array $args)
    {

        $today = date('Y-m-d');
        return $this->twig->render($response, 'daily-menus.html.twig',
            [
                'dailymenus' => $this->dailyMenuDao->getDailyMenu($today)
            ]
        );
    }

}