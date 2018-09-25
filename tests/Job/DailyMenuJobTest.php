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
        $mockHtmlParser = $this->getMockHtmlParser();
        $mockHtmlParser
            ->expects($this->once())
            ->method('load')
            ->with('http://www.vendiaketterem.hu/', ['preserveLineBreaks' => true]);

        $mockHtmlParser->loadStr(
            file_get_contents(__DIR__ . '/../Parser/HtmlContent/Vendiak.html'),
            ['preserveLineBreaks' => true]
        );
        $this->dailyMenuJob = new DailyMenu(new VendiakParser($mockHtmlParser),
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

//    /**
//     * @test
//     */
//    public function run_GivenVendiakDailyMenuIsAlreadySaved_DoesNotInsertItAgain()
//    {
//        $mockHTMLParser = $this->getMockBuilder(Dom::class)
//            ->setMethods(['load'])
//            ->getMock();
//        $this->dailyMenuJob = new DailyMenu(new VendiakParser($mockHTMLParser),
//            new DailyMenuDao((new PdoFactory())->getPdo()));
//
//        $this->insertRestaurants([$this->aRestaurant()]);
//        $this->insertMenus([$this->aMenu(1, 1, $this->dateOfToday)]);
//        $this->dailyMenuJob->run();
//        $dateOfToday = date('Y-m-d');
//        $actualDailyMenu = $this->getDailyMenuFromMenuTable($dateOfToday);
//        $this->assertEquals(1, count($actualDailyMenu));
//    }

//    /**
//     * @test
//     */
//    public function run_GivenParsersWork_BothDailyMenusAreInserted()
//    {
//        $this->insertRestaurants(
//            [
//                [
//                'id' => 1,
//                'name' => 'Véndiák Cafe Lounge',
//                ],
//                [
//                    'id' => 2,
//                    'name' => 'Muzikum Klub & Bistro',
//                ]
//            ]
//        );
//        $mockHtmlParser = $this->getMockHtmlParser();
//        $mockHtmlParser
//            ->expects($this->once())
//            ->method('load')
//            ->with('http://www.vendiaketterem.hu/', ['preserveLineBreaks' => true]);
//
//        $mockHtmlParser->loadStr(
//            file_get_contents(__DIR__ . '/../Parser/HtmlContent/Vendiak.html'),
//            ['preserveLineBreaks' => true]
//        );
//        $this->dailyMenuJob = new DailyMenu(new VendiakParser($mockHtmlParser),
//            new DailyMenuDao((new PdoFactory())->getPdo()));
//        $this->dailyMenuJob->run();
//
//        $expectedDailyMenu = [
//            'id' => 1,
//            'restaurant_id' => 1,
//            'menu' => 'Házi tea, Zöldségkrémleves, Milánói sertésborda',
//            'date' => $this->dateOfToday
//        ];
//        $actualDailyMenu = $this->getDailyMenuFromMenuTable($this->dateOfToday);
//        $this->assertEquals($expectedDailyMenu, $actualDailyMenu[0]);
//    }
}