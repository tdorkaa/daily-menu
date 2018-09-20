<?php

namespace Tests\Job;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\Job\DailyMenu;
use DailyMenu\Parser\VendiakParser;
use DailyMenu\PdoFactory;
use PHPHtmlParser\Dom;
use PHPUnit\Framework\TestCase;
use Tests\DbHelper;
use Tests\MockHtmlParser;

class DailyMenuTest extends TestCase
{
    use DbHelper;
    use MockHtmlParser;

    protected function setUp()
    {
        $this->setUpPdo();
        $this->truncate('restaurants');
        $this->truncate('menus');
    }

    /**
     * @test
     */
    public function run_GivenVendiakParserGivesBackSourceCode_DailyMenuIsInsertedToDB()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $dailyMenuJob = new DailyMenu(new VendiakParser($this->getMockHtmlParser()),
                                      new DailyMenuDao((new PdoFactory())->getPdo()));
        $dailyMenuJob->run();

        $dateOfToday = date('Y-m-d');
        $expectedDailyMenu = [
            'id' => 1,
            'restaurant_id' => 1,
            'menu' => 'Házi tea, Zöldségkrémleves, Milánói sertésborda',
            'date' => $dateOfToday
        ];
        $actualDailyMenu = $this->getDailyMenuFromMenuTable($dateOfToday);
        $this->assertEquals($expectedDailyMenu, $actualDailyMenu[0]);
    }
}