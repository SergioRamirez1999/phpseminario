<?php

    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    DEFINE("USERNAME_REGEX",'/^[a-zA-Z0-9]{6,}$/');
    DEFINE("EMAIL_REGEX",'/^([a-zA-Z0-9]+)([\.a-z0-9]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/');
    DEFINE("PASSWORD_REGEX",'/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9#?!@$%^&*-]).{6,}$/');
    DEFINE("NAME_REGEX",'/^[a-zA-Z ]+$/');
    DEFINE("LASTNAME_REGEX",'/^[a-zA-Z ]+$/');
    
    if(isset($_POST["user-username"]) 
        && isset($_POST["user-email"]) 
        && isset($_POST["user-password"]) 
        && isset($_POST["user-name"]) 
        && isset($_POST["user-lastname"])
        && isset($_FILES["user-image"]["tmp_name"]) 
        && !empty($_FILES["user-image"]["tmp_name"])){
        
        
        if(preg_match(USERNAME_REGEX, $_POST["user-username"])
            && preg_match(EMAIL_REGEX, $_POST["user-email"])
            && preg_match(PASSWORD_REGEX, $_POST["user-password"])
            && preg_match(NAME_REGEX, $_POST["user-name"])
            && preg_match(LASTNAME_REGEX, $_POST["user-lastname"])){
            
            if($_FILES["user-image"]["type"] == "image/jpeg")
                $imageType = "jpg";
            else
                $imageType = "png";

            $imageContent = file_get_contents(addslashes($_FILES["user-image"]["tmp_name"]));

            $user = array("name" => $_POST["user-name"],
                            "lastname" => $_POST["user-lastname"],
                            "email" => $_POST["user-email"],
                            "username" => $_POST["user-username"],
                            "password" => md5($_POST["user-password"]),
                            "imageContent" => $imageContent,
                            "imageType" => $imageType);


            //SE DEBE VERIFICAR SI YA EXITE UN USUARIO CON ESE USERNAME
            //TAL VEZ ARROJAR EXCEPTION DESDE EL MODEL

            UserController::saveUser($user);

            if(session_status() == PHP_SESSION_NONE)
                session_start();

            $_SESSION["user_data"] = UserController::getUserByUsername($user["username"]);

            $response = array("status" => 200, 
            "body" => json_encode(array("name" => $user["name"], "lastname" => $user["lastname"], "email" => $user["email"], "username" => $user["username"])), 
            "message" => "Registro de usuario exitoso: usted sera redireccionado.");

        }else {
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Registro de usuario erroneo: los campos ingresados no son validos.");
        }
        
    }else {
        $response = array("status" => 400, 
            "body" => "", 
            "message" => "Registro de usuario erroneo: por favor intente mas tarde.");
    }

    echo json_encode($response);
?>