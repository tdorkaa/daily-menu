<?php

namespace Tests;

use DailyMenu\PdoFactory;

trait DbHelper
{
    private $pdo;

    private function setUpPdo()
    {
        $this->pdo = (new PdoFactory())->getPDO();
    }

    private function truncate($table)
    {
        $this->pdo->query('TRUNCATE TABLE ' . $table);
    }

    private function insertMenus(array $menus): void
    {
        foreach ($menus as $menu) {
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

            $this->pdo->exec($sql);
        }
    }

    private function insertRestaurants(array $restaurants): void
    {
        foreach ($restaurants as $restaurant) {
            $sql = "
                INSERT INTO restaurants (id, name)
                VALUES ({$restaurant['id']}, '{$restaurant['name']}')
                ";
            $this->pdo->exec($sql);
        }
    }

}