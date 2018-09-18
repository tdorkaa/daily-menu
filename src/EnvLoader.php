<?php

namespace DailyMenu;

use Dotenv\Dotenv;

class EnvLoader
{

    public function loadEnvVars()
    {
        $appEnv = getenv('APPLICATION_ENV');

        $envDir = __DIR__ . '/../config/';
        $envFile = $appEnv . '.env';

        if(is_file($envDir . $envFile)) {
            $envLoader = new Dotenv($envDir, $envFile);
            $envLoader->overload();
        }
    }
}