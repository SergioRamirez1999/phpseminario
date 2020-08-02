<?php
require_once ROOT_DIR.'/models/dao/factory/mysql.concrete.php';
class ConnectionFactory {
    function createConnection($database){
        switch($database){
            case "MYSQL":
                return new MySqlDatabaseConnection();
                break;
            default:
                return new MySqlDatabaseConnection();
        }
    }
}