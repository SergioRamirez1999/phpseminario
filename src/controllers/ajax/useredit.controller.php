<?php
    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_POST["user_id"]) 
            && isset($_POST["field"]) 
            && isset($_POST["value"]) || (isset($_FILES["value"]["tmp_name"]) 
            && !empty($_FILES["value"]["tmp_name"]))) {
            $user_id = $_POST["user_id"];
            $field = $_POST["field"];

            if(isset($_POST["value"]))
                $value = $_POST["value"];

            if($field == "imagen_contenido" && isset($_FILES["value"]["tmp_name"]) 
            && !empty($_FILES["value"]["tmp_name"])){

                if($_FILES["value"]["type"] == "image/jpeg")
                    $imageType = "jpg";
                else
                    $imageType = "png";

                $imageContent = file_get_contents(addslashes($_FILES["value"]["tmp_name"]));

                UserController::editUserImage($user_id, $imageContent, $imageType);

                $response = array("status" => 200, 
                "body" => "", 
                "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
                
            }else if($field == "contrasenia"){
                if(isset($_POST["actual_password"])){
                    $user = UserController::getUserById($user_id);
                    $actual_pwd = $_POST["actual_password"];
                    $new_pwd = md5($value);
                    if($user["contrasenia"] == md5($actual_pwd)){

                        if($user["contrasenia"] != $new_pwd){

                            UserController::editUserById($user_id, $field, $new_pwd);
                            $response = array("status" => 200, 
                            "body" => "", 
                            "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
                        }else {
                            $response = array("status" => 404, 
                            "body" => "", 
                            "message" => "Edicion de usuario erroneo: la nueva contrasenia no debe coincidir con la actual.");    
                        }
                    }else {
                        //actual_password != actual_bbdd
                        $response = array("status" => 404, 
                        "body" => "", 
                        "message" => "Edicion de usuario erroneo: contrasenia actual incorrecta.");
                    }
                }else {
                    $response = array("status" => 404, 
                    "body" => "", 
                    "message" => "Edicion de usuario erroneo: por favor intente mas tarde.");
                }
            }else {
                UserController::editUserById($user_id, $field, $value);
                $response = array("status" => 200, 
                "body" => "", 
                "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
            }

            $_SESSION["user_data"] = UserController::getUserById($user_id);

        }else {
            $response = array("status" => 404, 
            "body" => "", 
            "message" => "Edicion de usuario erroneo: por favor intente mas tarde.");
        }

        echo json_encode($response);
    }


?>