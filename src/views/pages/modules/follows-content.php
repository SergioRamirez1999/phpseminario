<?php

    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){

        if(isset($_GET["username"]) && isset($_GET["profile"])){

            $user = $_SESSION["user_data"];
            $profile = $_GET["profile"];
            $username = $_GET["username"];

            $userController = new UserController();
    
            //FOLLOWS DE USUARIO DISTINTO AL DE SESION
            if($username != $user->getUsername())
                $user = $userController->getByUsername($username);
            
            if($user){
                if($profile == "followers"){
                    $userFollows = $userController->getFollowers($user->getId());
                    $followings = $userController->getFollowings($user->getId());
                }else if($profile == "followings"){
                    $userFollows = $userController->getFollowings($user->getId());
                }
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

<!--EL CENTRO SE QUEDA SI NO HAY SIZE-->
<section class="between-content">

    <div class="fx fx-column">
        <nav class="navigator-menu fx fx-ai-ctr fx-jc-sa">

            <div class="nav-menu-opt fx fx-jc-ctr" id="btn-followers">
                <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user->getUsername() ?>&profile=followers" class="nav-link">
                    <span>Seguidores</span>
                </a>
            </div>
            <div class="nav-menu-opt fx fx-jc-ctr" id="btn-followings">
                <a href="http://localhost/phpseminario/src?page=follows&username=<?php echo $user->getUsername() ?>&profile=followings" class="nav-link">
                    <span>Siguiendo</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="post-general-content" id="follows-container">

       
        
    </div>


    <input type="hidden" value="<?php echo $user->getId()?>" id="user_id_input">
    <input type="hidden" value="<?php echo $profile?>" id="profile_input">
    
    <script type="module" src="views/js/followersfollowings.js"></script>

</section>
