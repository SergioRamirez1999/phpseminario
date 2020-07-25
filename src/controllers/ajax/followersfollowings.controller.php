<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/following.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        $userController = new UserController();
        $followingController = new FollowingController();

        if(isset($_POST["user_id"]) && isset($_POST["profile"])){
            $user_id = $_POST["user_id"];
            $profile = $_POST["profile"];

            if($profile == "followings"){
                //obtener siguiendo
                $users = $userController->getFollowings($user_id);

                $data = array_map(function($user){
                    return array("id" => $user->getId(),
                    "nombreusuario" => $user->getUsername(),
                    "nombre" => $user->getName(),
                    "apellido" => $user->getLastname(),
                    "is_following" => "true",
                    "imagen_contenido" => $user->getPhotoContent() != null);

                }, $users);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Administrador de seguimiento: usuarios siguiendo.");

            }else if($profile == "followers"){
                //obtener seguidores y saber si yo los sigo
                $users = $userController->getFollowers($user_id);

                $data = array_map(function($user) use ($followingController, $user_id){

                    $is_following = $followingController->isFollowing($user_id, $user->getId());

                    return array("id" => $user->getId(),
                    "nombreusuario" => $user->getUsername(),
                    "nombre" => $user->getName(),
                    "apellido" => $user->getLastname(),
                    "is_following" => $is_following != null,
                    "imagen_contenido" => $user->getPhotoContent() != null);

                }, $users);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Administrador de seguimiento: usuarios seguidores.");


            } else {
                $response = array("status" => 400, 
                "body" => "", 
                "message" => "El administrador de seguimiento de usuario presenta errores: por favor intente mas tarde.");
            }
        }else {
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "El administrador de seguimiento de usuario presenta errores: por favor intente mas tarde.");
        }

    }else {
        $response = array("status" => 401, 
        "body" => "", 
        "message" => "El administrador de seguimiento de usuario presenta errores: usted no tiene permisos necesarios.");
    
    }
    echo json_encode($response);