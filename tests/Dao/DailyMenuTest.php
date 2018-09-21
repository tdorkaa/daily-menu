<?php

namespace Tests\Dao;

use DailyMenu\Dao\DailyMenu;
use PHPUnit\Framework\TestCase;
use Tests\DbHelper;

class DailyMenuTest extends TestCase
{
    use DbHelper;

    /**
     * @var DailyMenu
     */
    private $dao;

    protected function setUp()
    {
        $this->setUpPdo();
        $this->truncate('restaurants');
        $this->truncate('menus');
        $this->dao = new DailyMenu($this->pdo);
    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDate_ReturnsMenusOfDate()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$this->aMenu()]);

        $expectedDailyMenu = [[
            'id' => '1',
            'restaurant_id' => '1',
            'restaurant' => 'Fiction Stars1',
            'menu' => 'Leves, Fozelek1',
            'date' => '2018-09-22'
        ]];

        $actualDailyMenu = $this->dao->getDailyMenus('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }

    /**
     * @test
     */
    public function getDailyMenu_DbContainsMenusWithDifferentDates_ReturnsMenusOfDate()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$this->aMenu(), $this->aMenu(2, 1, '2018-09-22'), $this->aMenu(3, 1, '2018-09-21')]);

        $expectedDailyMenu = [[
            'id' => '1',
            'restaurant_id' => '1',
            'restaurant' => 'Fiction Stars1',
            'menu' => 'Leves, Fozelek1',
            'date' => '2018-09-22'
        ], [
            'id' => '2',
            'restaurant_id' => '1',
            'restaurant' => 'Fiction Stars1',
            'menu' => 'Leves, Fozelek2',
            'date' => '2018-09-22'
        ]];

        $actualDailyMenu = $this->dao->getDailyMenus('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }

    /**
     * @test
     */
    public function insertDailyMenu_GivenRestaurantAlreadyExists_DbContainsInsertedMenu()
    {
        $this->insertRestaurants([$this->aRestaurant()]);

        $expectedDailyMenu = [
            [
                'id' => '1',
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menu' => 'Leves, Fozelek1',
                'date' => '2018-09-22'
            ]
        ];
        $this->dao->insertDailyMenu(1, 'Leves, Fozelek1', '2018-09-22');
        $actualDailyMenu = $this->dao->getDailyMenus('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }

    /**
     * @test
     */
    public function isDailyMenuByRestaurantIdExists_GivenDailyMenuAlreadyInserted_ReturnsTrue()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$this->aMenu(1,1, date('Y-m-d'))]);
        $actual = $this->dao->isDailyMenuByRestaurantIdExists(1);
        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function getMenusByDateOrderByRestaurantId_GivenPeriodOfTime_ReturnsMenusOrderByRestaurantId()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertRestaurants([$this->aRestaurant(2)]);
        $this->insertMenus([$this->aMenu()]);
        $this->insertMenus([$this->aMenu(2,1, date('2018-09-11'))]);
        $this->insertMenus([$this->aMenu(3,2, date('2018-09-12'))]);
        $this->insertMenus([$this->aMenu(4,1, date('2018-09-10'))]);
        $expected = [
            [
                'id' => '1',
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menu' => 'Leves, Fozelek1',
                'date' => '2018-09-22'
            ],
            [
                'id' => '2',
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menu' => 'Leves, Fozelek2',
                'date' => '2018-09-11'
            ],
            [
                'id' => '3',
                'restaurant_id' => '2',
                'restaurant' => 'Fiction Stars2',
                'menu' => 'Leves, Fozelek3',
                'date' => '2018-09-12'
            ]
        ];
        $actual = $this->dao->getMenusByDateOrderByRestaurantId('2018-09-11', '2018-09-22');
        $this->assertEquals($expected, $actual);
    }
}