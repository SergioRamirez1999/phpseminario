<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/following.controller.php";

    DEFINE("EMAIL_REGEX",'/^([a-zA-Z0-9]+)([\.a-z0-9]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/');
    DEFINE("PASSWORD_REGEX",'/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9#?!@$%^&*-]).{6,}$/');
    DEFINE("NAME_LASTNAME_REGEX",'/^[a-zA-Z ]+$/');

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_POST["user_id"]) 
            && isset($_POST["field"]) 
            && isset($_POST["value"]) || (isset($_FILES["value"]["tmp_name"]) 
            && !empty($_FILES["value"]["tmp_name"]))) {

            $userController = new UserController();
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

                $userController->uploadImage($user_id, $imageContent, $imageType);

                $response = array("status" => 200, 
                "body" => "", 
                "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
                
            }else if($field == "contrasenia"){
                if(isset($_POST["actual_password"])){
                    $user = $userController->getById($user_id);
                    $actual_pwd = $_POST["actual_password"];
                    $new_pwd = md5($value);
                    if($user->getPassword() == md5($actual_pwd)){

                        if($user->getPassword() != $new_pwd){

                            $userController->update($user_id, $field, $new_pwd);
                            $response = array("status" => 200, 
                            "body" => "", 
                            "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
                        }else {
                            $response = array("status" => 404, 
                            "body" => "", 
                            "message" => "Edicion de usuario erroneo: la nueva contrasenia no debe coincidir con la actual.");    
                        }
                    }else {
                        $response = array("status" => 404, 
                        "body" => "", 
                        "message" => "Edicion de usuario erroneo: contrasenia actual incorrecta.");
                    }
                }else {
                    $response = array("status" => 404, 
                    "body" => "", 
                    "message" => "Edicion de usuario erroneo: por favor intente mas tarde.");
                }
            }else if($field == "nombre" || $field == "apellido") {
                if(preg_match(NAME_LASTNAME_REGEX, $value)){
                    $userController->update($user_id, $field, $value);
                    $response = array("status" => 200, 
                    "body" => "", 
                    "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
                }else {
                    $response = array("status" => 400, 
                    "body" => "", 
                    "message" => "Edicion de usuario erroneo: al menos 6 caracteres alfanumericos.");
                }
            }else if($field == "email") {
                if(preg_match(EMAIL_REGEX, $value)){
                    $userController->update($user_id, $field, $value);
                    $response = array("status" => 200, 
                    "body" => "", 
                    "message" => "Edicion de usuario exitoso: el usuario ha sido actualizado.");
                }else {
                    $response = array("status" => 400, 
                    "body" => "", 
                    "message" => "Edicion de usuario erroneo: ingrese un correo electronico valido.");
                }
            }

            $_SESSION["user_data"] = $userController->getById($user_id);

        }else {
            $response = array("status" => 404, 
            "body" => "", 
            "message" => "Edicion de usuario erroneo: por favor intente mas tarde.");
        }

        echo json_encode($response);
    }


?>