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
            $userController = new UserController();
            $usersFound = $userController->getByCriteria($keyword);
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
    <div class="post-general-content" id="follows-container">
        <?php if(isset($usersFound) && count($usersFound) > 0):?>
            <?php foreach($usersFound as $key => $element):?>
                <div class="follows-layout-content fx fx-ai-ctr">
                    <div class="left-layout-content fx fx-jc-ctr fx-ai-ctr">
                        <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element->getUsername()?>&menu_opt=posts">
                            <div class="user-logo-container">
                                <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $element->getId()?>" alt="user image">
                            </div>
                        </a>
                    </div>
                    <div class="right-layout-content">
                        <div class="top-content-post fx fx-jc-btw fx-ai-ctr">
                            <div class="user-username-content fx fx-column">
                                <div class="post-user-name">
                                    <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element->getUsername()?>&menu_opt=posts">
                                        <span><?php echo $element->getName().' '.$element->getLastname()?></span>
                                    </a>
                                </div>
                                <div class="post-user-username">
                                    <span><?php echo '@'.$element->getUsername()?></span>
                                </div>
                            </div>
                            <div class="btn btn-danger follows-button">Dejar de seguir</div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php else: ?>
            <div>
                no hay resultados
            </div>
        <?php endif; ?>
    </div>
</section>