<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DailyMenu\EnvLoader;

$envLoader = new EnvLoader();
$envLoader->loadEnvVars();