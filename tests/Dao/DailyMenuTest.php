<?php

namespace Tests\Dao;

use DailyMenu\Dao\DailyMenu;
use PHPUnit\Framework\TestCase;
use Tests\DbHelper;

class DailyMenuTest extends TestCase
{
    use DbHelper;

    protected function setUp()
    {
        $this->setUpPdo();
        $this->truncate('restaurants');
        $this->truncate('menus');
    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDate_ReturnsMenusOfDate()
    {
        $this->insertRestaurants([self::aRestaurant()]);
        $this->insertMenus([self::aMenu()]);

        $expectedDailyMenu = [
            'id' => '1',
            'restaurant_id' => '1',
            'restaurant' => 'Fiction Stars1',
            'menu' => 'Leves, Fozelek1',
            'date' => '2018-09-22'
        ];


        $dao = new DailyMenu($this->pdo);

        $actualDailyMenu = $dao->getDailyMenu('2018-09-22');

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