<?php

namespace DailyMenu\Job;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\Parser\ParserHelper;
use DailyMenu\Parser\VendiakParser;

class DailyMenu
{
    /**
     * @var VendiakParser
     */
    private $vendiakParser;
    /**
     * @var DailyMenuDao
     */
    private $dailyMenuDao;

    public function __construct(VendiakParser $vendiakParser, DailyMenuDao $dailyMenuDao)
    {
        $this->vendiakParser = $vendiakParser;
        $this->dailyMenuDao = $dailyMenuDao;
    }

    public function run()
    {
        if(!$this->dailyMenuDao->isDailyMenuByRestaurantIdExists(1)) {
            $menu = implode(', ', $this->vendiakParser->getDailyMenu(new ParserHelper()));
            $this->dailyMenuDao->insertDailyMenu(1, $menu, date('Y-m-d'));
        }
    }
}