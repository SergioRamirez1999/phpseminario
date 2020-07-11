<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/message.controller.php";
    require_once ROOT_DIR."/controllers/like.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        $likeController = new LikeController();
        $messageController = new MessageController();
        if(isset($_POST["id_message"])){

            $likeController->deleteByMessageId($_POST["id_message"]);

            $messageController->delete($_POST["id_message"]);

            $response = array("status" => 200, 
            "body" => "", 
            "message" => "Eliminacion de post exitoso: el post ha sido eliminado.");

        }else {
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Eliminacion de post erroneo: por favor intente mas tarde.");
        }
        
    }else {
        $response = array("status" => 401, 
        "body" => "", 
        "message" => "Eliminacion de post: usted no esta autorizado.");
    }
    echo json_encode($response);


?>