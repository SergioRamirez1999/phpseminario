<?php

require_once 'bootstrap.php';
require_once ROOT_DIR.'/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CustomLogger {

    public static function getLogger(){
        $logger = new Logger('DefaultLogger');
        $logger->pushHandler(new StreamHandler(ROOT_DIR.'/../server.log', Logger::DEBUG));
        return $logger;
    }
}
?>