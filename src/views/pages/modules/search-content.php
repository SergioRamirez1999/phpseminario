<?php
    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_GET["q"])){
            $user = $_SESSION["user_data"];
    
            $keyword = $_GET["q"];
    
            $usersFound = UserController::searchUsersByCriteria($keyword);

        } else {
            echo '<script> window.location.href = "http://localhost/phpseminario/src?page=home</script>';
        }

    }else {
        echo '<script> window.location.href = "http://localhost/phpseminario/src"</script>';
    }

?>

<section class="between-content">

    <div class="top-layout-container fx fx-jc-ctr">

        <div class="browser-content-large fx">
            <div class="browser-center-content fx fx-jc-ctr fx-ai-ctr">
                <div class="icon-search"></div>
                <input class="input-search-brw input-search" type="text" placeholder="personas, keywords" value="<?php echo $keyword?>">
            </div>
        </div>

    </div>
    
    <div class="post-general-content" id="follows-container">

        <?php if(isset($usersFound) && count($usersFound) > 0):?>
            <?php foreach($usersFound as $key => $element):?>

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

                            <div class="btn btn-danger follows-button" >Dejar de seguir</div>

                        </div>

                    </div>

                </div>

            <?php endforeach;?>
        <?php else: ?>

            <div class="">
                no hay resultados
            </div>

        <?php endif; ?>
        
    </div>

</section>