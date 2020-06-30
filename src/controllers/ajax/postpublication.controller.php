<?php
    require_once "../user.controller.php";
    require_once "../../models/user.model.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){

        $maxLength = 140;

        if(isset($_POST["post-commentary"]) 
            && !empty($_POST["post-commentary"]) 
            && strlen($_POST["post-commentary"]) <= $maxLength){

            

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

            $message = array("text" => $_POST["post-commentary"],
                                "image_content" => $imageContent,
                                "image_type" => $imageType,
                                "user_id_fk" => $_SESSION["user_data"]["id"],
                                "create_at" => date('Y-m-d H:i:s'));

            
            if(UserController::savePost($message)){
                $response = array("status" => 200, 
                "body" => json_encode($message), 
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

    }else {
        $response = array("status" => 400, 
            "body" => "", 
            "message" => "Guardado de post erroneo: por favor intente mas tarde.");
    }

    echo json_encode($response);
?>
