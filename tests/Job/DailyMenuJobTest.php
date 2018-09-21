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

    private $dateOfToday;
    private $dailyMenuJob;

    protected function setUp()
    {
        $this->setUpPdo();
        $this->truncate('restaurants');
        $this->truncate('menus');
        $this->dateOfToday = date('Y-m-d');
    }

    /**
     * @test
     */
    public function run_GivenVendiakParserGivesBackSourceCode_DailyMenuIsInsertedToDB()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->dailyMenuJob = new DailyMenu(new VendiakParser($this->getMockHtmlParser()),
            new DailyMenuDao((new PdoFactory())->getPdo()));
        $this->dailyMenuJob->run();

        $expectedDailyMenu = [
            'id' => 1,
            'restaurant_id' => 1,
            'menu' => 'Házi tea, Zöldségkrémleves, Milánói sertésborda',
            'date' => $this->dateOfToday
        ];
        $actualDailyMenu = $this->getDailyMenuFromMenuTable($this->dateOfToday);
        $this->assertEquals($expectedDailyMenu, $actualDailyMenu[0]);
    }

    /**
     * @test
     */
    public function run_GivenVendiakDailyMenuIsAlreadySaved_DoesNotInsertItAgain()
    {
        $mockHTMLParser = $this->getMockBuilder(Dom::class)
            ->setMethods(['load'])
            ->getMock();
        $this->dailyMenuJob = new DailyMenu(new VendiakParser($mockHTMLParser),
            new DailyMenuDao((new PdoFactory())->getPdo()));

        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$this->aMenu(1, 1, $this->dateOfToday)]);
        $this->dailyMenuJob->run();
        $dateOfToday = date('Y-m-d');
        $actualDailyMenu = $this->getDailyMenuFromMenuTable($dateOfToday);
        $this->assertEquals(1, count($actualDailyMenu));
    }
}