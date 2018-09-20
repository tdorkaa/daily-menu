<?php

namespace DailyMenu\Dao;

class DailyMenu
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDailyMenus(string $date)
    {
        $sql = "
            SELECT menus.id, menus.restaurant_id, restaurants.name restaurant, menus.menu, menus.date
            FROM menus menus
            INNER JOIN restaurants restaurants
            ON menus.restaurant_id = restaurants.id 
            WHERE menus.date=:date
        ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'date' => $date
        ]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertDailyMenu($restaurantId, $menu, $date)
    {
        $this->pdo->prepare('
           INSERT INTO menus (
                restaurant_id, 
                menu, 
                `date`
           )
           VALUES (
                :restaurant_id, 
                :menu, 
                :date
           )
        ')->execute(array(
            ':restaurant_id' => $restaurantId,
            ':menu' => $menu,
            ':date' => $date
        ));
    }
}