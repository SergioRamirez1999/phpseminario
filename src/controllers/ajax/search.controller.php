<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/following.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        if(isset($_POST["q"])){
            $user_session = $_SESSION["user_data"];
            $keyword = $_POST["q"];

            $userController = new UserController();
            $followingController = new FollowingController();

            $usersFound = $userController->getByCriteria($keyword);

            $data = array_map(function($user) use ($user_session, $followingController){

                $is_following = $followingController->isFollowing($user_session->getId(), $user->getId());

                return array("id" => $user->getId(),
                "nombreusuario" => $user->getUsername(),
                "nombre" => $user->getName(),
                "apellido" => $user->getLastname(),
                "is_following" => $is_following != null,
                "imagen_contenido" => $user->getPhotoContent() != null);

            }, $usersFound);

            $response = array("status" => 200, 
            "body" => json_encode($data), 
            "message" => "Administrador de busqueda: ".count($data)." resultados encontrados para ".$keyword.".");

        }else {
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "El administrador de busqueda presenta errores: por favor intente mas tarde.");
        }
    }else {
        $response = array("status" => 401, 
        "body" => "", 
        "message" => "El administrador de busqueda presenta errores: usted no tiene permisos necesarios.");
    }
    echo json_encode($response);