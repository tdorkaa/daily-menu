<?php
namespace tests;

use DailyMenu\EnvLoader;

class EnvLoaderTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function loadEnvVars_DependingOnApplicationEnv()
    {
        $originalAppEnv = getenv("APPLICATION_ENV");
        putenv('APPLICATION_ENV=development');

        $envLoader = new EnvLoader();
        $envLoader->loadEnvVars();
        $dbName = getenv('DB_NAME');
        $this->assertEquals('dailymenu', $dbName);

        putenv("APPLICATION_ENV={$originalAppEnv}");
    }

    /**
     * @test
     */
    public function loadEnvVars_AppEnvFileDoesNotExists_NoExceptionThrown()
    {
        $this->expectNotToPerformAssertions();
        $originalAppEnv = getenv("APPLICATION_ENV");
        putenv('APPLICATION_ENV=somethingsomethingdarkside');

        $envLoader = new EnvLoader();
        $envLoader->loadEnvVars();


        putenv("APPLICATION_ENV={$originalAppEnv}");
    }
}