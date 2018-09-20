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

}