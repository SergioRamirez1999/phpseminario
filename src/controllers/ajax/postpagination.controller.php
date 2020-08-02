<?php
    require_once "../../config/bootstrap.php";
    require_once ROOT_DIR."/models/entities/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";
    require_once ROOT_DIR."/controllers/like.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        if(isset($_POST["user_id"]) && isset($_POST["origin"]) && isset($_POST["rows"]) && isset($_POST["page"]) && isset($_POST["menu_opt"])) {
            $user_session = $_SESSION["user_data"];
            $user_id = $_POST["user_id"];
            $origin = $_POST["origin"];
            $rows = $_POST["rows"];
            $page = $_POST["page"];
            $menu_opt = $_POST["menu_opt"];

            $userController = new UserController();
            $messageController = new MessageController();
            $likeController = new LikeController();

            if($page == "feed"){

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
                //Se debe tener en cuenta la perspectiva del usuario en session para los likes, y no del usuario del perfil. 

                //usuario, puede ser el mismo usuario de session u otro usuario
                $user = $userController->getById($user_id);

                if($menu_opt == "posts"){
                    $posts = $userController->getPaginationMessages($user->getId(), $origin, $rows);
                }else if($menu_opt == "images"){
                    $posts = $userController->getPaginationMessages($user->getId(), $origin, $rows, true);
                }else if($menu_opt == "likes"){
                    //obtener los mensajes likeados por el usuario(perfil/session)
                    $posts = $messageController->getPaginationLiked($user->getId(), $origin, $rows);
                }else {
                    $response = array("status" => 400, 
                    "body" => "", 
                    "message" => "Paginacion de posts erroneo: por favor intente mas tarde.");
                }

                if($menu_opt == "likes"){

                    $data = array_map(function($post) use ($user_session, $messageController, $likeController){
                        
                        $c_likes = $messageController->getCountLikes($post["id_mensaje"]);
                        
                        //saber si el usuario de session likeo este mensaje
                        //Si user_session == user -> redundancia
                        $liked = $likeController->isLiked($user_session->getId(), $post["id_mensaje"]);
                        
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
                    }, array_values($posts));

                }else if($menu_opt == "posts" || $menu_opt == "images") {
                    $data = array_map(function($post) use ($user, $user_session, $messageController, $likeController){
                        
                        $c_likes = $messageController->getCountLikes($post->getId());
                        
                        //saber si el usuario de session likeo este mensaje
                        $liked = $likeController->isLiked($user_session->getId(), $post->getId());
                        
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
                }


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