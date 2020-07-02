<?php

    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_POST["user_id"]) && isset($_POST["profile"])){
            $user_id = $_POST["user_id"];
            $profile = $_POST["profile"];

            if($profile == "followings"){
                //obtener siguiendo y saber si ellos me siguen
                $users = UserController::getFollowingsById($user_id);

                $data = array_map(function($user) use ($user_id){
                    $us_fw = UserController::getFollowingsById($user["id"]);
                    $us_fw_id = array_map(function($us){
                        return $us["id"];
                    }, $us_fw);

                    $is_following = in_array($user_id, $us_fw_id);

                    return array("id" => $user["id"],
                    "nombreusuario" => $user["nombreusuario"],
                    "nombre" => $user["nombre"],
                    "apellido" => $user["apellido"],
                    "is_following" => $is_following == TRUE ? 'followingme' : 'notfollowingme',
                    "imagen_contenido" => isset($user["foto_contenido"]));

                }, $users);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Administrador de seguimiento: usuarios siguiendo.");

            }else if($profile == "followers"){
                //obtener seguidores y saber si yo los sigo
                $users = UserController::getFollowersById($user_id);

                $data = array_map(function($user) use ($user_id){
                    $us_fw = UserController::getFollowersById($user["id"]);
                    $us_fw_id = array_map(function($us){
                        return $us["id"];
                    }, $us_fw);

                    $is_following = in_array($user_id, $us_fw_id);

                    return array("id" => $user["id"],
                    "nombreusuario" => $user["nombreusuario"],
                    "nombre" => $user["nombre"],
                    "apellido" => $user["apellido"],
                    "is_following" => $is_following == TRUE ? 'followingyou' : 'notfollowingyou',
                    "imagen_contenido" => isset($user["foto_contenido"]));

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

?>
