<?php
    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        if(isset($_POST["user_id"]) && isset($_POST["post_id"]) && isset($_POST["is_liked"])){
            $user_id = $_POST["user_id"];
            $post_id = $_POST["post_id"];
            $is_liked = $_POST["is_liked"];
            if($is_liked == "liked"){
                //deslikear
                UserController::removeLike($_POST["user_id"], $_POST["post_id"]);
            }else if($is_liked == "unliked"){
                //likear
                UserController::saveLike($_POST["user_id"], $_POST["post_id"]);
            }

            $response = array("status" => 200, 
            "body" => "", 
            "message" => "Operacion exitosa: like guardado.");

        }else {

            $response = array("status" => 400, 
            "body" => "", 
            "message" => "La operacion no ha sido exitosa: por favor intente mas tarde.");

        }
        echo json_encode($response);
    }


?>