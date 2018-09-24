<?php

namespace DailyMenu;

class PdoFactory
{

    private static $pdoInstance = null;

    public function getPdo()
    {
        if (!self::$pdoInstance) {
            self::$pdoInstance = new \PDO($this->getDsn(),
                getenv('DB_USER'),
                getenv('DB_PASSWORD'),
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING));
        }
        return self::$pdoInstance;
    }

    /**
     * @param $dbname
     * @return string
     */
    private function getDsn(): string
    {
        $dbname = getenv('DB_NAME');
        $host = getenv('HOST');
        return "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    }
}