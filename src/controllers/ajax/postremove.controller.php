<?php
    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_POST["id_message"])){

            UserController::removePostById($_POST["id_message"]);

            $response = array("status" => 200, 
            "body" => "", 
            "message" => "Eliminacion de post exitoso: el post ha sido eliminado.");

        }else {
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Eliminacion de post erroneo: por favor intente mas tarde.");
        }
        
        echo json_encode($response);
    }


?>