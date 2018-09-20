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

    private function getDailyMenuFromMenuTable($date)
    {
        $sql = "
            SELECT id, restaurant_id, menu, `date`
            FROM menus
            WHERE date=:date
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'date' => $date
        ]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
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