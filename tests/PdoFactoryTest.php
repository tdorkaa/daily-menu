<?php

namespace Tests;

use DailyMenu\PdoFactory;
use PHPUnit\Framework\TestCase;

class PdoFactoryTest extends TestCase
{
    
    /**
     * @test 
     */
    public function getPdo_ReturnsPDOConnectedToDatabase()
    {
        $factory = new PdoFactory();
        $pdo = $factory->getPdo();
        $statement = $pdo->query("SELECT DATABASE()");
        $selectedDb = $statement->fetch(\PDO::FETCH_NUM);
        $this->assertEquals(getenv('DB_NAME'), $selectedDb[0]);
    }

    /**
     * @test
     */
    public function getPdo_CalledMultipleTimes_ReturnsTheSameObject()
    {
        $factory = new PdoFactory();
        $pdo1 = $factory->getPdo();
        $pdo2 = $factory->getPdo();
        $this->assertSame($pdo1, $pdo2);
    }


}