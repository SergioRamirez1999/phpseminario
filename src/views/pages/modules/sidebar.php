<?php
    require_once ROOT_DIR."/models/user.entity.php";
    
    if(session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION["user_data"])){
        $user = $_SESSION["user_data"];
    }else {
        session_destroy();
        header("Location: http://localhost/phpseminario/src");
    }
?>
<section class="left-content fx fx-column fx-ai-ctr">
    <a href="http://localhost/phpseminario/src?page=home" class="lk-logo-web">
        <img src="views/img/logo-white.png" class="logo-web" alt="world logo">
    </a>
    <div class="sidebar-container fx fx-jc-ctr">
        <nav class="navigator-container">
            <a href="http://localhost/phpseminario/src?page=home">
                <div class="fx fx-jc-sa fx-ai-ctr">
                    <div class="icon-sidebar icon-home"></div>
                    <span class="option-title">Inicio</span>
                </div>
            </a>
            <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user->getUsername()?>&menu_opt=posts">
                <div class="fx fx-jc-sa fx-ai-ctr">
                    <div class="icon-sidebar icon icon-user"></div>
                    <span class="option-title">Perfil</span>
                </div>
            </a>
            <a href="http://localhost/phpseminario/src?page=logout">
                <div class="fx fx-jc-sa fx-ai-ctr">
                    <div class="icon-sidebar icon icon-user"></div>
                    <span class="option-title">Salir</span>
                </div>
            </a>
        </nav>
    </div>
    <div class="comment-button-content fx fx-jc-ctr fx-ai-ctr" id="btn-cmt">
        <span class="btn-title">Comentar</span>
    </div>
    <script type="module" src="views/js/modal-new-cmt.js"></script>
</section>