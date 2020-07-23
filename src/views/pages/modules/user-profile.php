<?php
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/following.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){

        $user_session = $_SESSION["user_data"];

        $userController = new UserController();
        $followingController = new FollowingController();

        if(isset($_GET["username"]) && isset($_GET["menu_opt"])){

            $menu_opt = $_GET["menu_opt"];

            if($user_session->getName() == $_GET["username"]){
                $user = $user_session;
            }else {
                $user = $userController->getByUsername($_GET["username"]);
            }
    
            if($user){
                $followingsUserProfile = $userController->getFollowings($user->getId());
            
                $followersUserProfile = $userController->getFollowers($user->getId());

                //codigo para saber si estoy siguiendo al usuario
                $isFollowing = $followingController->isFollowing($user_session->getId(), $user->getId());

            }else {
                header("Location: http://localhost/phpseminario/src?page=home");
            }
        }else {
            header("Location: http://localhost/phpseminario/src?page=home");
        }

    }else {
        session_destroy();
        header("Location: http://localhost/phpseminario/src");
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

                <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user->getId()?>" alt="user image" class="profile-user-image" id="user-image-profile">


                <?php if($user_session->getUsername() == $_GET["username"]):?>
                
                    <div class="button-edit fx fx-jc-ctr fx-ai-ctr" id="btn-edit-user">
                        <span>Editar</span>
                    </div>

                    <input type="hidden" value="<?php echo $user->getId()?>" id="user_data_id">
                    <input type="hidden" value="<?php echo $user->getName()?>" id="user_data_name">
                    <input type="hidden" value="<?php echo $user->getLastname()?>" id="user_data_lastname">
                    <input type="hidden" value="<?php echo $user->getEmail()?>" id="user_data_email">

                <?php else: ?>

                    <?php if(isset($isFollowing)): ?>
                        <div class="button-follow fx fx-jc-ctr fx-ai-ctr" following="true" id="btn-follow-user">
                            <span>Siguiendo</span>
                        </div>
                    <?php else: ?>
                        <div class="button-follow fx fx-jc-ctr fx-ai-ctr" following="false" id="btn-follow-user">
                            <span>Seguir</span>
                        </div>
                    <?php endif; ?>
                    
                    <input type="hidden" id="user_id" value="<?php echo $user_session->getId()?>">
                    <input type="hidden" id="follow_user_id" value="<?php echo $user->getId()?>">
                <?php endif; ?>

            </div>

            <script type="module" src="views/js/modal-edit-user.js"></script>

            <script type="module" src="views/js/follow-unfollow.js"></script>
        </div>

        <div class="bottom-content-profile">
            <div class="user-info-content fx fx-column fx-jc-sa">
                <div class="row-user-info">
                    <h2 class="name-user-profile" id="user-name-profile"><?php echo $user->getName().' '.$user->getLastname()?></h2>
                </div>
                <div class="row-user-info">
                    <span class="username-user-profile"><?php echo '@'.$user->getUsername()?></span>
                </div>
                <div class="row-user-info">
                    <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user->getUsername()?>&profile=followings" class="flwers-fling-lk">
                        <span class="followings-user" id="span_followings"><?php echo count($followingsUserProfile)?>&nbsp;siguiendo</span>
                    </a>
                    <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user->getUsername()?>&profile=followers" class="flwers-fling-lk">
                        <span class="followers-user" id="span_followers"><?php echo count($followersUserProfile)?>&nbsp;seguidores</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <nav class="navigator-menu fx fx-ai-ctr fx-jc-sa">
        <div class="nav-menu-opt fx fx-jc-ctr opt-selected">
            <a href="#" class="nav-link">
                <span>Posts</span>
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
    <input type="hidden" value="<?php echo $user->getId()?>" id="user_id_input">
    <input type="hidden" value="<?php echo $user_session->getId()?>" id="user_session_id_input">

</section>


