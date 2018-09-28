<?php

namespace DailyMenu\Job;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\Parser\ParserHelper;
use Monolog\Logger;
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
    private $parserRestaurantMap;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(DailyMenuDao $dailyMenuDao, array $parserRestaurantMap, Logger $logger)
    {
        $this->dailyMenuDao = $dailyMenuDao;
        $this->parserRestaurantMap = $parserRestaurantMap;
        $this->logger = $logger;
    }

    public function run()
    {
        $dateOfToday = date('Y-m-d');
        $restaurants = $this->dailyMenuDao->getRestaurants();
        foreach ($restaurants as $restaurant) {
            try {

                if ($this->dailyMenuDao->isDailyMenuByRestaurantIdExists($restaurant['id'])) {
                    continue;
                }

                $parser = new $this->parserRestaurantMap[$restaurant['name']](new Dom());
                $menu = implode(', ', $parser->getDailyMenu($dateOfToday));
                $this->dailyMenuDao->insertDailyMenu($restaurant['id'], $menu, $dateOfToday);
            } catch (\Exception $exception) {
                $this->logger->addError($exception->getMessage());
            }
        }
    }
}