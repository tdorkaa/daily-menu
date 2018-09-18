<?php

namespace Tests\Dao;

use DailyMenu\Dao\DailyMenu;
use PHPUnit\Framework\TestCase;
use Tests\DbHelper;

class DailyMenuTest extends TestCase
{
    use DbHelper;

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
        $this->insertRestaurants([self::aRestaurant()]);
        $this->insertMenus([self::aMenu()]);

        $expectedDailyMenu = [[
            'id' => '1',
            'restaurant_id' => '1',
            'restaurant' => 'Fiction Stars1',
            'menu' => 'Leves, Fozelek1',
            'date' => '2018-09-22'
        ]];

        $actualDailyMenu = $this->dao->getDailyMenu('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }

    /**
     * @test
     */
    public function getDailyMenu_DbContainsMenusWithDifferentDates_ReturnsMenusOfDate()
    {
        $this->insertRestaurants([self::aRestaurant()]);
        $this->insertMenus([self::aMenu(), self::aMenu(2, 1, '2018-09-22'), self::aMenu(3, 1, '2018-09-21')]);

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

        $actualDailyMenu = $this->dao->getDailyMenu('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }

    /**
     * @test
     */
    public function insertDailyMenu_GivenRestaurantAlreadyExists_DbContainsInsertedMenu()
    {
        $this->insertRestaurants([self::aRestaurant()]);

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
        $actualDailyMenu = $this->dao->getDailyMenu('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }



    private static function aRestaurant($restaurantId = 1)
    {
        return [
            'id' => $restaurantId,
            'name' => 'Fiction Stars' . $restaurantId,
        ];
    }

    private static function aMenu($id = 1, $restaurantId = 1, $date = '2018-09-22')
    {
        return [
            'id' => $id,
            'restaurant_id' => $restaurantId,
            'menu' => 'Leves, Fozelek' . $id,
            'date' => $date
        ];
    }

}