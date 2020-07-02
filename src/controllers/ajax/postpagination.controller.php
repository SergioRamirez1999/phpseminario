<?php
    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        if(isset($_POST["user_id"]) && isset($_POST["origin"]) && isset($_POST["rows"]) && isset($_POST["page"])) {
            $user_id = $_POST["user_id"];
            $origin = $_POST["origin"];
            $rows = $_POST["rows"];
            $page = $_POST["page"];

            if($page == "home"){

                $posts = UserController::getFollowingsPosts($user_id, $origin, $rows);
                
                $data = array_map(function($post){
                    
                    $likes = UserController::getLikesByPostId($post["id_mensaje"]);
                    $c_likes = count($likes);
                    
                    $id_likes = array_map(function($like){
                        return $like["usuarios_id"];
                    }, $likes);
                    
                    $liked = in_array($_POST["user_id"], $id_likes);
                    
                    return array("id_user" => $post["id_user"],
                    "nombreusuario_user" => $post["nombreusuario_user"],
                    "nombre_user" => $post["nombre_user"],
                    "apellido_user" => $post["apellido_user"],
                    "id_mensaje" => $post["id_mensaje"],
                    "texto_mensaje" => $post["texto_mensaje"],
                    "fechayhora_mensaje" => $post["fechayhora_mensaje"],
                    "likes" => $c_likes,
                    "is_liked" => $liked == true ? 'liked':'unliked',
                    "imagen_contenido" => isset($post["imagen_contenido_mensaje"]));
                }, $posts);

                $response = array("status" => 200, 
                "body" => json_encode($data), 
                "message" => "Paginacion de posts exitosa: pagina ".$origin.", registos ".count($posts).".");

            }else if($page == "profile"){

                $user = UserController::getUserById($user_id);

                $posts = UserController::getPostsById($user["id"], $origin, $rows);

                $data = array_map(function($post) use ($user){
                    
                    $likes = UserController::getLikesByPostId($post["id"]);
                    $c_likes = count($likes);
                    
                    $id_likes = array_map(function($like){
                        return $like["usuarios_id"];
                    }, $likes);
                    
                    $liked = in_array($_POST["user_id"], $id_likes);
                    
                    return array("id_user" => $user["id"],
                    "nombreusuario_user" => $user["nombreusuario"],
                    "nombre_user" => $user["nombre"],
                    "apellido_user" => $user["apellido"],
                    "id_mensaje" => $post["id"],
                    "texto_mensaje" => $post["texto"],
                    "fechayhora_mensaje" => $post["fechayhora"],
                    "likes" => $c_likes,
                    "is_liked" => $liked == true ? 'liked':'unliked',
                    "imagen_contenido" => isset($post["imagen_contenido"]));
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


?>