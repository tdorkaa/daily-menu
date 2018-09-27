<?php

namespace Tests\Job;

use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\Job\DailyMenu;
use DailyMenu\Parser\ParserHelper;
use DailyMenu\Parser\ParserMapper;
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
        $this->insertRestaurants([[
            'id' => 1,
            'name' => 'Véndiák Cafe Lounge',
        ]]);

        $mockParserMapper = [
            'Véndiák Cafe Lounge' => FakeVendiakParser::class
        ];

        $this->dailyMenuJob = new DailyMenu(
            new DailyMenuDao((new PdoFactory())->getPdo()), $mockParserMapper);
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
        $this->insertRestaurants([[
            'id' => 1,
            'name' => 'Véndiák Cafe Lounge',
        ]]);
        $this->insertMenus([$this->aMenu(1, 1, $this->dateOfToday)]);
        $mockParserMapper = [
            'Véndiák Cafe Lounge' => FakeVendiakParser::class
        ];
        $this->dailyMenuJob = new DailyMenu(
            new DailyMenuDao((new PdoFactory())->getPdo()), $mockParserMapper);

        $this->dailyMenuJob->run();
        $dateOfToday = date('Y-m-d');
        $actualDailyMenu = $this->getDailyMenuFromMenuTable($dateOfToday);
        $this->assertEquals(1, count($actualDailyMenu));
    }

    /**
     * @test
     */
    public function run_GivenTwoRestaurantParsers_InsertBothDailyMenu()
    {
        self::markTestIncomplete();
        $this->insertRestaurants(
            [
                [
                    'id' => 1,
                    'name' => 'Véndiák Cafe Lounge',
                ],
                [
                    'id' => 2,
                    'name' => 'Muzikum Klub & Bistro',
                ]
            ]
        );

        $mockParserMapper = [
            'Véndiák Cafe Lounge' => FakeVendiakParser::class,
            'Muzikum Klub & Bistro' => FakeMuzikumParser::class
        ];
        $this->dailyMenuJob = new DailyMenu(
            new DailyMenuDao((new PdoFactory())->getPdo()), $mockParserMapper);
        $this->dailyMenuJob->run();

        $expectedDailyMenu = [
            [
                'id' => 1,
                'restaurant_id' => 1,
                'menu' => 'Házi tea, Zöldségkrémleves, Milánói sertésborda',
                'date' => $this->dateOfToday
            ],
            [
                'id' => 2,
                'restaurant_id' => 2,
                'menu' => 'Francia hagymaleves diós veknivel,
                           Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával',
                'date' => $this->dateOfToday
            ]
        ];
        $actualDailyMenu = $this->getDailyMenuFromMenuTable($this->dateOfToday);
        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);

    }
}