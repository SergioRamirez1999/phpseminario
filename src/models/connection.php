<?php


Class DatabaseConnection {

    static public function getConnection(){

        $link = new PDO("mysql:host=127.0.0.1;dbname=seminario",
                        "root",
                        "ApiReflection"
                        );

        $link->exec("set names utf8");

        return $link;
    }
}

?>