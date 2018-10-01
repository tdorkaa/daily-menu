<?php
//db must contains restaurant in restaurants table
use DailyMenu\Dao\DailyMenu as DailyMenuDao;
use DailyMenu\EnvLoader;
use DailyMenu\Job\DailyMenu as DailyMenuJob;
use DailyMenu\Parser\ParserMapper;
use DailyMenu\PdoFactory;

require __DIR__ . '/../vendor/autoload.php';

$envLoader = new EnvLoader();
$envLoader->loadEnvVars();
$date = date('H:i:s');

if($date < '12:00:00') {
    $dailyMenuJob = new DailyMenuJob(
        new DailyMenuDao((new PdoFactory())->getPdo()),
        ParserMapper::getParserMap(),
        (new \DailyMenu\LoggerFactory())->build()
    );
    $dailyMenuJob->run();
}
