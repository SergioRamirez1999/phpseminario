<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";
    if(isset($_GET["image_type"])){

        if($_GET["image_type"] == "user" && isset($_GET["id_user"])){

            $userController = new UserController();

            $user = $userController->getById($_GET["id_user"]);
            
            if($user && !empty($user->getPhotoType()) && !empty($user->getPhotoContent())){
                header('Content-type', $user->getPhotoType());
                echo $user->getPhotoContent();
            }else {
                header('Content-type', 'png');
                echo file_get_contents('../../views/img/user-default-1.png');
            }

        }else if($_GET["image_type"] == "message" && isset($_GET["id_message"])) {

            $messageController = new MessageController();

            $message = $messageController->getById($_GET["id_message"]);
            
            if($message && !empty($message->getImageType()) && !empty($message->getImageContent())){
                header('Content-type', $message->getImageType());
                echo $message->getImageContent();
            }

        }
    }
