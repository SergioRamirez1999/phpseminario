<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/auth/login.authentication.php";

    if(isset($_POST["username"]) && isset($_POST["password"])){

        try {
            $userDto = UsernamePasswordAuthentication::attemptAuthentication();
            $response = array("status" => 200, 
            "body" => $userDto,
            "message" => "Inicio de sesion exitoso: usted sera redireccionado.");
        } catch (UserNotFoundException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}", array("context" => "USER SIGNIN"));
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Inicio de sesion erroneo: usuario inexistente.");
        } catch (UserBadCredentialsException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}", array("context" => "USER SIGNIN"));
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Inicio de sesion erroneo: credenciales no validas.");
        }

    }else {
        $response = array("status" => 400, 
        "body" => "", 
        "message" => "Inicio de sesion erroneo: por favor intente mas tarde.");
    }
    echo json_encode($response);