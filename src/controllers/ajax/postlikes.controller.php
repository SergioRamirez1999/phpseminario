<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/entities/user.entity.php";
    require_once ROOT_DIR."/models/entities/like.entity.php";
    require_once ROOT_DIR."/controllers/like.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        if(isset($_POST["user_id"]) && isset($_POST["post_id"]) && isset($_POST["is_liked"])){
            $user_id = $_POST["user_id"];
            $post_id = $_POST["post_id"];
            $is_liked = $_POST["is_liked"];

            $likeController = new LikeController();
            
            if($is_liked == "liked"){
                //deslikear
                $likeController->deleteByFks($user_id, $post_id);
            }else if($is_liked == "unliked"){
                //likear
                $likeController->save(new Like(null, $user_id, $post_id));
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