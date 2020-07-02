<?php

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){

        if(isset($_GET["username"]) && isset($_GET["profile"])){

            $user = $_SESSION["user_data"];
            $profile = $_GET["profile"];
            $username = $_GET["username"];
    
            //FOLLOWS DE USUARIO DISTINTO AL DE SESION
            if($username != $user["nombreusuario"])
                $user = UserController::getUserByUsername($username);
            
            if($user){
                if($profile == "followers"){
                    $userFollows = UserController::getFollowersById($user["id"]);
                    $followings = UserController::getFollowingsById($user["id"]);
                }else if($profile == "followings"){
                    $userFollows = UserController::getFollowingsById($user["id"]);
                }
            }else {
                echo '<script> window.location.href = "http://localhost/phpseminario/src?page=home"</script>';    
            }
        }else {
            echo '<script> window.location.href = "http://localhost/phpseminario/src"</script>';
        }

    }else {
        echo '<script> window.location.href = "http://localhost/phpseminario/src?page=home"</script>';
    }
?>

<!--EL CENTRO SE QUEDA SI NO HAY SIZE-->
<section class="between-content">

    <div class="fx fx-column">
        <nav class="navigator-menu fx fx-ai-ctr fx-jc-sa">

            <div class="nav-menu-opt fx fx-jc-ctr opt-selected" id="btn-followers">
                <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user["nombreusuario"] ?>&profile=followers" class="nav-link">
                    <span>Seguidores</span>
                </a>
            </div>
            <div class="nav-menu-opt fx fx-jc-ctr" id="btn-followings">
                <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user["nombreusuario"] ?>&profile=followings" class="nav-link">
                    <span>Siguiendo</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="post-general-content" id="follows-container">

        <?php if(isset($userFollows)):?>

            <?php if($profile == "followers" && isset($followings)):?>
                <?php
                    //obtengo a quienes sigo

                    $ids = array_map(function($user){
                        return $user["id"];
                    }, $followings);

                    //si el id del seguidor esta en el array de siguiendo, entonces boton dejar de seguir
                ?>

            <?php endif; ?>

            <?php foreach($userFollows as $key => $element): ?>
                <div class="follows-layout-content fx fx-ai-ctr">

                    <div class="left-layout-content fx fx-jc-ctr fx-ai-ctr">

                        <!-- IMAGEN DE USUARIO -->
                        <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element["nombreusuario"]?>">
                            <div class="user-logo-container">
                                <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $element["id"]?>" alt="user image">
                            </div>
                        </a>
                    </div>

                    <div class="right-layout-content">

                        <div class="top-content-post fx fx-jc-btw fx-ai-ctr">

                            <div class="user-username-content fx fx-column">
                                <!-- NOMBRE DE USUARIO -->
                                <div class="post-user-name">
                                    <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element["nombreusuario"]?>">
                                        <span><?php echo $element["nombre"].' '.$element["apellido"]?></span>
                                    </a>
                                </div>
                                <!-- USERNAME DE USUARIO -->
                                <div class="post-user-username">
                                    <span><?php echo '@'.$element["nombreusuario"]?></span>
                                </div>

                            </div>

                            <?php if($profile == "followers"):?>

                                <?php if(in_array($element["id"], $ids)): ?>
                                    <div class="btn btn-primary follows-button" user_owner="<?php echo $user["id"]?>" user_host="<?php echo $element["id"]?>">Siguiendo</div>
                                <?php else: ?>
                                    <div class="btn btn-primary follows-button" user_owner="<?php echo $user["id"]?>" user_host="<?php echo $element["id"]?>">Seguir</div>    
                                <?php endif;?>
                                
                            <?php else:?>
                                <div class="btn btn-primary follows-button" user_owner="<?php echo $user["id"]?>" user_host="<?php echo $element["id"]?>">Siguiendo</div>
                            <?php endif;?>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>
        
    </div>

</section>
