<?php

    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/auth/register.authentication.php";
    
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
            
            try {
                $user = RegisterAuthentication::attemptRegister();
                $response = array("status" => 200, 
                "body" => json_encode($user), 
                "message" => "Registro de usuario exitoso: usted sera redireccionado.");
            } catch (UserExistsException $e) {
                CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}", array("context" => "USER SIGNUP"));
                $response = array("status" => 400, 
                "body" => "", 
                "message" => "Registro de usuario erroneo: el nombre de usuario ya se encuentra registrado.");
            }

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