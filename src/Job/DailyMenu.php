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
    private $parserMapper;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(DailyMenuDao $dailyMenuDao, array $parserMapper, Logger $logger)
    {
        $this->dailyMenuDao = $dailyMenuDao;
        $this->parserMapper = $parserMapper;
        $this->logger = $logger;
    }

    public function run()
    {
        $dateOfToday = date('Y-m-d');
        $restaurants = $this->dailyMenuDao->getRestaurants();
        foreach ($restaurants as $restaurant) {
            try {
                $parser = new $this->parserMapper[$restaurant['name']](new Dom());

                if (!$this->dailyMenuDao->isDailyMenuByRestaurantIdExists($restaurant['id'])) {
                    $menu = implode(', ', $parser->getDailyMenu(new ParserHelper(), date('Y-m-d')));
                    $this->dailyMenuDao->insertDailyMenu($restaurant['id'], $menu, $dateOfToday);
                }
            } catch (\Exception $exception) {
                $this->logger->addError($exception->getMessage());
            }
        }
    }
}