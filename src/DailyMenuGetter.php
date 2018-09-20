<?php
//db must contains restaurant in restaurants table
use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\EnvLoader;
use DailyMenu\Job\DailyMenu as DailyMenuJob;
use DailyMenu\Parser\VendiakParser;
use DailyMenu\PdoFactory;

require '../vendor/autoload.php';

$envLoader = new EnvLoader();
$envLoader->loadEnvVars();

$dailyMenuJob = new DailyMenuJob(new VendiakParser(new PHPHtmlParser\Dom),
                                 new DailyMenuDao((new PdoFactory())->getPdo()));
$dailyMenuJob->run();