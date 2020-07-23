<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";
    require_once ROOT_DIR."/controllers/like.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        if(isset($_POST["user_id"]) && isset($_POST["origin"]) && isset($_POST["rows"]) && isset($_POST["page"])) {
            $user_id = $_POST["user_id"];
            $origin = $_POST["origin"];
            $rows = $_POST["rows"];
            $page = $_POST["page"];

            $userController = new UserController();
            $messageController = new MessageController();
            $likeController = new LikeController();

            if($page == "home"){

                $posts = $messageController->getPaginationFromFollowings($user_id, $origin, $rows);
                
                $data = array_map(function($post) use ($messageController, $likeController, $user_id){
                    
                    $c_likes = $messageController->getCountLikes($post["id_mensaje"]);
                    
                    $liked = $likeController->isLiked($user_id, $post["id_mensaje"]);
                    
                    return array("id_user" => $post["id_user"],
                    "nombreusuario_user" => $post["nombreusuario_user"],
                    "nombre_user" => $post["nombre_user"],
                    "apellido_user" => $post["apellido_user"],
                    "id_mensaje" => $post["id_mensaje"],
                    "texto_mensaje" => $post["texto_mensaje"],
                    "fechayhora_mensaje" => $post["fechayhora_mensaje"],
                    "likes" => $c_likes,
                    "is_liked" => $liked != null ? 'liked':'unliked',
                    "imagen_contenido" => isset($post["imagen_contenido_mensaje"]));
                }, $posts);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Paginacion de posts exitosa: pagina ".$origin.", registos ".count($posts).".");

            }else if($page == "profile"){

                $user = $userController->getById($user_id);

                $posts = $userController->getPaginationMessages($user->getId(), $origin, $rows);

                $data = array_map(function($post) use ($user, $messageController, $likeController){
                    
                    $c_likes = $messageController->getCountLikes($post->getId());
                    
                    $liked = $likeController->isLiked($user->getId(), $post->getId());
                    
                    return array("id_user" => $user->getId(),
                    "nombreusuario_user" => $user->getUsername(),
                    "nombre_user" => $user->getName(),
                    "apellido_user" => $user->getLastname(),
                    "id_mensaje" => $post->getId(),
                    "texto_mensaje" => $post->getText(),
                    "fechayhora_mensaje" => $post->getCreateAt(),
                    "likes" => $c_likes,
                    "is_liked" => $liked != null ? 'liked':'unliked',
                    "imagen_contenido" => $post->getImageContent() != null);
                }, $posts);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Paginacion de posts exitosa: pagina ".$origin.", registos ".count($posts).".");
            }else {
                $response = array("status" => 400, 
                "body" => "", 
                "message" => "Paginacion de posts erroneo: por favor intente mas tarde.");
            }

        }else {

            $response = array("status" => 400, 
            "body" => "", 
            "message" => "Paginacion de posts erroneo: por favor intente mas tarde.");

        }
    }else {

        $response = array("status" => 401, 
        "body" => "", 
        "message" => "Paginacion de posts: usted no esta autorizado.");

    }
    echo json_encode($response);

