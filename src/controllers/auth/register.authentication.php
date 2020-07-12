<?php
require_once "../../config/bootstrap.php";
require_once ROOT_DIR."/controllers/user.controller.php";
require_once ROOT_DIR."/controllers/auth/exceptions/user.exception.php";

DEFINE("USERNAME_REGEX",'/^[a-zA-Z0-9]{6,}$/');
DEFINE("EMAIL_REGEX",'/^([a-zA-Z0-9]+)([\.a-z0-9]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/');
DEFINE("PASSWORD_REGEX",'/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9#?!@$%^&*-]).{6,}$/');
DEFINE("NAME_REGEX",'/^[a-zA-Z ]+$/');
DEFINE("LASTNAME_REGEX",'/^[a-zA-Z ]+$/');

class RegisterAuthentication {

    public static function attemptRegister(){

        $userController = new UserController();
        
        if($_FILES["user-image"]["type"] == "image/jpeg")
            $imageType = "jpg";
        else
            $imageType = "png";

        $imageContent = file_get_contents(addslashes($_FILES["user-image"]["tmp_name"]));

        $user = new User(null, $_POST["user-name"],
                        $_POST["user-lastname"],
                        $_POST["user-email"],
                        $_POST["user-username"],
                        md5($_POST["user-password"]),
                        $imageContent,
                        $imageType);

        $user_exists = $userController->getByUsername($user->getUsername());

        if(isset($user_exists)){
            throw new UserExistsException("El usuario [{$user->getUsername()}] ya existe en la base de datos.");
        }

        $user = $userController->save($user);
        
        if($user){
            if(session_status() == PHP_SESSION_NONE)
                session_start();

            $_SESSION["user_data"] = $user;
        }

        return $user;

    }
}

?>