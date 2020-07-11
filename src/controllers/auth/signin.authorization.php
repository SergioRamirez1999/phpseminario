<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/dao/imp/user.imp.php";

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $userController = new UserController();
        $user = $userController->getByUsername($_POST["username"]);
        if($user){
            $pass_hash = md5($_POST["password"]);
            if($user->getPassword() == $pass_hash){

                if(session_status() == PHP_SESSION_NONE)
                    session_start();
                    
                $_SESSION["user_data"] = $user;

                $response = array("status" => 200, 
                "body" => json_encode($user), 
                "message" => "Inicio de sesion exitoso: usted sera redireccionado");
            }else {
                $response = array("status" => 400, 
                "body" => "", 
                "message" => "Inicio de sesion erroneo: credenciales no validas");
            }
        }else {
            $response = array("status" => 400, 
                "body" => "", 
                "message" => "Inicio de sesion erroneo: credenciales no validas");
        }
        
    }else {
        $response = array("status" => 400, 
        "body" => "", 
        "message" => "Inicio de sesion erroneo: por favor intente mas tarde.");
    }
    
    echo json_encode($response);
?>
