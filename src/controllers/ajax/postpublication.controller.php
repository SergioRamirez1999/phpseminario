<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/models/message.entity.php";
    require_once ROOT_DIR."/controllers/message.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){

        $user = $_SESSION["user_data"];

        $maxLength = 140;

        if(isset($_POST["post-commentary"]) 
            && !empty($_POST["post-commentary"]) 
            && strlen($_POST["post-commentary"]) <= $maxLength){

            $messageController = new MessageController();

            if(isset($_FILES["post-image"]["tmp_name"]) 
                && !empty($_FILES["post-image"]["tmp_name"])){

                $imageContent = file_get_contents(addslashes($_FILES["post-image"]["tmp_name"]));

                if($_FILES["post-image"]["type"] == "image/jpeg")
                    $imageType = "jpg";
                else
                    $imageType = "png";

            }else {
                $imageContent = null;
                $imageType = null;
            }

            $message = new Message(null, $_POST["post-commentary"], $imageContent, $imageType, $user->getId(), date('Y-m-d H:i:s'));

            $message_saved = $messageController->save($message);

            $c_likes = $messageController->getCountLikes($message_saved->getId());

            if(isset($message_saved)){
                $data = array("id_user" => $user->getId(),
                "nombreusuario_user" => $user->getUsername(),
                "nombre_user" => $user->getName(),
                "apellido_user" => $user->getLastname(),
                "id_mensaje" => $message_saved->getId(),
                "texto_mensaje" => $message_saved->getText(),
                "fechayhora_mensaje" => $message_saved->getCreateAt(),
                "likes" => $c_likes,
                "is_liked" => 'unliked',
                "imagen_contenido" => $message_saved->getImageContent() != null);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Guardado de post exitoso: el post fue publicado.");
            }else {
                $response = array("status" => 505, 
                "body" => "", 
                "message" => "Guardado de post erroneo: el post no fue publicado debido a falla en el servidor, por favor intente mas tarde.");    
            }

            
        }else {
            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Guardado de post erroneo: por favor intente mas tarde.");
        }
        
        echo json_encode($response);
    }