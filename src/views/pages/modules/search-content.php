<?php
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";
    if(session_status() == PHP_SESSION_NONE)
        session_start();
    if(isset($_SESSION["user_data"])){
        $user = $_SESSION["user_data"];
        if(isset($_GET["q"])){
            $keyword = $_GET["q"];
        }else {
            header("Location: http://localhost/phpseminario/src?page=home");
        }
    }else {
        session_destroy();
        header("Location: http://localhost/phpseminario/src");
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
    <div class="post-general-content" id="results-container">
    </div>

    <input type="hidden" value="<?php echo $user->getId()?>" id="user_session_id_input">
    <input type="hidden" value="<?php echo $user->getId()?>" id="user_id_input">
    <input type="hidden" value="search" id="page_input">
    <input type="hidden" value="<?php echo $user->getUsername()?>" id="user_session_username_input">
    <input type="hidden" value="<?php echo $keyword?>" id="keyword_input">

    <script type="module" src="views/js/search.js"></script>
</section>