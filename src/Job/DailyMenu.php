<?php

namespace DailyMenu\Job;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\Parser\ParserHelper;
use PHPHtmlParser\Dom;

class DailyMenu
{
    /**
     * @var DailyMenuDao
     */
    private $dailyMenuDao;
    /**
     * @var array
     */
    private $parserMapper;

    public function __construct(DailyMenuDao $dailyMenuDao, array $parserMapper)
    {
        $this->dailyMenuDao = $dailyMenuDao;
        $this->parserMapper = $parserMapper;
    }

    public function run()
    {
        $vendiakParser = new $this->parserMapper['Véndiák Cafe Lounge'](new Dom());

        if(!$this->dailyMenuDao->isDailyMenuByRestaurantIdExists(1)) {
            $menu = implode(', ', $vendiakParser->getDailyMenu(new ParserHelper()));
            $this->dailyMenuDao->insertDailyMenu(1, $menu, date('Y-m-d'));
        }
    }
}