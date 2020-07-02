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

       
        
    </div>

    <script type="module" src="views/js/followersfollowings.js"></script>

    <input type="hidden" value="<?php echo $user["id"]?>" id="user_id_input">
    <input type="hidden" value="<?php echo $profile?>" id="profile_input">

</section>
