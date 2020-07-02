<?php

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        if(isset($_GET["username"])){

            if($_SESSION["user_data"]["nombreusuario"] == $_GET["username"]){
                $user = $_SESSION["user_data"];
            }else {
                $user = UserController::getUserByUsername($_GET["username"]);
            }
    
            if($user){
                $followingsUserProfile = UserController::getFollowingsById($user["id"]);
            
                $followersUserProfile = UserController::getFollowersById($user["id"]);
    
                foreach($followersUserProfile as $key => $element){
                    if(in_array($_SESSION["user_data"]["id"], $element)){
                        $isFollowing = true;
                        break;
                    }
                }
    
                $postsUserProfile = UserController::getPostsById($user["id"]);
    
            }else {
                echo '<script> window.location.href = "http://localhost/phpseminario/src?page=home" </script>';
            }
        }else {
            echo '<script> window.location.href = "http://localhost/phpseminario/src" </script>';
        }

    }else {
        echo '<script> window.location.href = "http://localhost/phpseminario/src" </script>';
    }
?>

<section class="between-content">

    <div class="user-profile-content fx fx-column">

        <div class="top-content-profile">

            <div class="user-cover-image">
                <img src="" alt="">
            </div>

        </div>

        <div class="mid-content-profile fx fx-jc-ctr">

            <div class="profile-center-content fx fx-jc-btw">

                <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user["id"]?>" alt="user image" class="profile-user-image" id="user-image-profile">


                <?php if($_SESSION["user_data"]["nombreusuario"] == $_GET["username"]):?>
                
                    <div class="button-edit fx fx-jc-ctr fx-ai-ctr" id="btn-edit-user">
                        <span>Editar</span>
                    </div>

                    <input type="hidden" value="<?php echo $user["id"]?>" id="user_data_id">
                    <input type="hidden" value="<?php echo $user["nombre"]?>" id="user_data_name">
                    <input type="hidden" value="<?php echo $user["apellido"]?>" id="user_data_lastname">
                    <input type="hidden" value="<?php echo $user["email"]?>" id="user_data_email">

                <?php else: ?>

                    <?php if(isset($isFollowing) && $isFollowing): ?>
                        <div class="button-follow fx fx-jc-ctr fx-ai-ctr" following="true" id="btn-follow-user">
                            <span>Siguiendo</span>
                        </div>
                    <?php else: ?>
                        <div class="button-follow fx fx-jc-ctr fx-ai-ctr" following="false" id="btn-follow-user">
                            <span>Seguir</span>
                        </div>
                    <?php endif; ?>
                    
                    <input type="hidden" id="user_id" value="<?php echo $_SESSION["user_data"]["id"]?>">
                    <input type="hidden" id="follow_user_id" value="<?php echo $user["id"]?>">
                <?php endif; ?>

            </div>

            <script type="module" src="views/js/modal-edit-user.js"></script>

            <script type="module" src="views/js/follow-unfollow.js"></script>
        </div>

        <div class="bottom-content-profile">
            <div class="user-info-content fx fx-column fx-jc-sa">
                <div class="row-user-info">
                    <h2 class="name-user-profile" id="user-name-profile"><?php echo $user["nombre"].' '.$user["apellido"]?></h2>
                </div>
                <div class="row-user-info">
                    <span class="username-user-profile"><?php echo '@'.$user["nombreusuario"] ?></span>
                </div>
                <div class="row-user-info">
                    <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user["nombreusuario"] ?>&profile=followings" class="flwers-fling-lk">
                        <span class="followings-user" id="span_followings"><?php echo count($followingsUserProfile)?>&nbsp;siguiendo</span>
                    </a>
                    <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user["nombreusuario"] ?>&profile=followers" class="flwers-fling-lk">
                        <span class="followers-user" id="span_followers"><?php echo count($followersUserProfile)?>&nbsp;seguidores</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <nav class="navigator-menu fx fx-ai-ctr fx-jc-sa">
        <div class="nav-menu-opt fx fx-jc-ctr opt-selected">
            <a href="#" class="nav-link">
                <span>Comentarios</span>
            </a>

        </div>
        <div class="nav-menu-opt fx fx-jc-ctr">
            <a href="#" class="nav-link">
                <span>Imagenes</span>
            </a>

        </div>
        <div class="nav-menu-opt fx fx-jc-ctr">
            <a href="#" class="nav-link">
                <span>Likes</span>
            </a>

        </div>

    </nav>

    <div class="post-general-content" id="posts-container">


        <!-- ####### POST 1 EXAMPLE #######-->

       

    </div>
    
    <script type="module" src="views/js/pagination.js"> </script>
    <script type="module" src="views/js/removepost.js"></script>
    <input type="hidden" value="profile" id="page_input">
    <input type="hidden" value="<?php echo $user["id"]?>" id="user_id_input">

</section>