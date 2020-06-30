<?php
    require_once "../../controllers/user.controller.php";
    require_once "../../models/user.model.php";
    if(isset($_GET["image_type"])){

        if($_GET["image_type"] == "user" && isset($_GET["id_user"])){

            
            $user = UserController::getUserById($_GET["id_user"]);
            
            if($user && !empty($user["foto_tipo"]) && !empty($user["foto_contenido"])){
                header('Content-type', $user["foto_tipo"]);
                echo $user["foto_contenido"];
            }else {
                header('Content-type', 'png');
                echo file_get_contents('../../views/img/user-default-1.png');
            }

        }else if($_GET["image_type"] == "message" && isset($_GET["id_message"])) {

            $message = UserController::getMessageById($_GET["id_message"]);
            
            if($message && !empty($message["imagen_tipo"]) && !empty($message["imagen_contenido"])){
                header('Content-type', $message["imagen_tipo"]);
                echo $message["imagen_contenido"];
            }

        }
    }
?>
