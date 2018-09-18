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

    public function getDailyMenu(string $date)
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
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}