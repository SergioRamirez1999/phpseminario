<?php
require_once "../../config/bootstrap.php";
require_once ROOT_DIR."/controllers/user.controller.php";
require_once ROOT_DIR."/controllers/auth/exceptions/user.exception.php";
require_once ROOT_DIR."/models/dto/user.dto.php";

class UsernamePasswordAuthentication {

    public static function attemptAuthentication(){
        $userController = new UserController();
        $user = $userController->getByUsername($_POST["username"]);

        if(!isset($user)){
            throw new UserNotFoundException("El usuario [{$_POST["username"]}] no existe en la base de datos.");
        }else {
            $pass_hash = md5($_POST["password"]);
            if($user->getPassword() == $pass_hash){

                if(session_status() == PHP_SESSION_NONE)
                    session_start();
                    
                $_SESSION["user_data"] = $user;

                return new UserDto($user->getId(), $user->getName(), $user->getLastname(), $user->getEmail(), $user->getUsername());

            }else{
                throw new UserBadCredentialsException("Credenciales invalidas.");
            }
        }
    }
}