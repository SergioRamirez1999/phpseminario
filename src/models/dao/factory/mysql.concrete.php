<?php
require_once ROOT_DIR.'/models/dao/factory/connection.product.php';
require_once ROOT_DIR.'/config/logger.php';
require_once ROOT_DIR.'/../vendor/autoload.php';

use Monolog\Logger;

class MySqlDatabaseConnection implements IDatabaseConnection {
    function getConnection(){
        try {
            $link = new PDO("mysql:host=127.0.0.1;dbname=seminario",
                            "root",
                            "ApiReflection"
                            );
    
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $link->exec("set names utf8");

            return $link;
        } catch (Exception $e) {
            CustomLogger::getLogger()->error($e->getFile().": Error al establecer conexion con la base de datos.");
        }
    }
}