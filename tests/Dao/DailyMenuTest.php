<?php

namespace tests;

use DailyMenu\Dao\DailyMenu;
use DailyMenu\PdoFactory;
use PHPUnit\Framework\TestCase;

class DailyMenuTest extends TestCase
{
    /**
     * @test
     */
    public function getDailyMenu_GivenDate_ReturnsMenusOfDate()
    {
        $pdo = (new PdoFactory())->getPdo();
        $pdo->query('TRUNCATE TABLE restaurants');
        $pdo->query('TRUNCATE TABLE menus');
        $restaurant = [
            'id' => 1,
            'name' => 'Fiction Stars',
        ];
        $this->createRestaurantInDb($restaurant);

        $menu = [
            'id' => 1,
            'restaurant_id' => 1,
            'menu' => 'Leves, Fozelek',
            'date' => '2018-09-22'
        ];
        $this->createMenuInDb($menu);

        $expectedDailyMenu = [
            'id' => '1',
            'restaurant_id' => '1',
            'restaurant' => 'Fiction Stars',
            'menu' => 'Leves, Fozelek',
            'date' => '2018-09-22'
        ];

        $pdo = (new PdoFactory())->getPdo();

        $dao = new DailyMenu($pdo);

        $actualDailyMenu = $dao->getDailyMenu('2018-09-22');

        $this->assertEquals($expectedDailyMenu, $actualDailyMenu);
    }

    /**
     * @param $menu
     */
    private function createMenuInDb($menu): void
    {
        $pdo = (new PdoFactory())->getPdo();
        $sql = "
        INSERT INTO menus (
          id, 
          restaurant_id, 
          menu, 
          `date`
        )
        VALUES (
            {$menu['id']}, 
            '{$menu['restaurant_id']}', 
            '{$menu['menu']}', 
            '{$menu['date']}'
        )
        ";

        $pdo->exec($sql);
    }

    /**
     * @param $restaurant
     */
    private function createRestaurantInDb($restaurant): void
    {
        $pdo = (new PdoFactory())->getPdo();

        $sql = "
        INSERT INTO restaurants (id, name)
        VALUES ({$restaurant['id']}, '{$restaurant['name']}')
        ";
        $pdo->exec($sql);
    }
}