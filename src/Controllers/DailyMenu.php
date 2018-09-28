<?php

namespace DailyMenu\Controllers;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\MenusConverter;
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
    /**
     * @var MenusConverter
     */
    private $menusConverter;

    public function __construct(Twig $twig, DailyMenuDao $dailyMenuDao, MenusConverter $menusConverter)
    {
        $this->twig = $twig;
        $this->dailyMenuDao = $dailyMenuDao;
        $this->menusConverter = $menusConverter;
    }

    public function getDailyMenus(Request $request, Response $response, array $args)
    {
        $date1 = $request->getParam('date1');
        $date2 = $request->getParam('date2');
        $menus = [];
        if(!empty($date1) && !empty($date2)) {
            $menus = $this->menusConverter->convert($this->dailyMenuDao->getMenusByDateOrderByRestaurantId($date1, $date2));
        }

        $today = date('Y-m-d');
        return $this->twig->render($response, 'daily-menus.html.twig',
            [
                'dailymenus' => $this->dailyMenuDao->getDailyMenus($today),
                'date1' => $date1,
                'date2' => $date2,
                'menus' => $menus
            ]
        );
    }
}