<?php

namespace DailyMenu;

use Monolog\Handler\StreamHandler;

class LoggerFactory
{
    public function build()
    {
        $logger = new \Monolog\Logger('my_logger');
        $file_handler = new StreamHandler('php://stdout');
        $logger->pushHandler($file_handler);
        return $logger;
    }

}