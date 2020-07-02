
<?php

    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_POST["user_id"]) && isset($_POST["user_id_fu"]) && isset($_POST["is_following"])){
            $userId = $_POST["user_id"];
            $userIdFu = $_POST["user_id_fu"];
            $isFollowing = $_POST["is_following"];
            if($isFollowing == "true"){
                $user_id = UserController::unfollowUserById($userId, $userIdFu);
                $response = array("status" => 200, 
                "body" => "unfollow", 
                "message" => "Eliminacion de seguimiento de usuario exitoso");
            }else {
                $user_id = UserController::followUserById($userId, $userIdFu);
                $response = array("status" => 200, 
                "body" => "follow", 
                "message" => "Seguimiento de usuario exitoso");
            }
    
            if($user_id == null){
                $response = array("status" => 505, 
                "body" => "", 
                "message" => "El administrador de seguimiento de usuario presenta errores: por favor intente mas tarde.");
            }
    
    
        }else {
    
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "El administrador de seguimiento de usuario presenta errores: por favor intente mas tarde.");
    
        }
    
        echo json_encode($response);

    }

?>