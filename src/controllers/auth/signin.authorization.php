<?php
    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $user = UserController::getUserByUsername($_POST["username"]);
        if($user){
            $pass_hash = md5($_POST["password"]);
            if($user["contrasenia"] == $pass_hash){

                if(session_status() == PHP_SESSION_NONE)
                    session_start();
                    
                $_SESSION["user_data"] = $user;

                $response = array("status" => 200, 
                "body" => json_encode(array("nombre" => $user["nombre"], "apellido" => $user["apellido"], "email" => $user["email"], "nombreusuario" => $user["nombreusuario"])), 
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
