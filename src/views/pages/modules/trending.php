<?php
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){

        $rowsTTUsers = 3;
        $rowsTTMessages = 3;

        $userController = new UserController();
        $messageController = new MessageController();

        $trendingUsers = $userController->getTrending($rowsTTUsers);
        $trendingMessages = $messageController->getTrending($rowsTTMessages);

    }else {
        session_destroy();
        header("Location: http://localhost/phpseminario/src");
    }
?>
<section class="right-content fx fx-column fx-ai-ctr">
    <div class="browser-content fx">
        <div class="browser-center-content fx fx-jc-ctr fx-ai-ctr">
            <div class="icon-search"></div>
            <input class="input-search-brw input-search" type="text" placeholder="personas, keywords">
        </div>
    </div>
    <script type="module" src="views/js/search.js"></script>
    <section class="trending-comments-content">
        <div class="comments-center-content">
            <div class="trending-title">
                <h2>Comentarios destacados</h2>
            </div>
            <div class="comments-content fx fx-column">
                <?php if(isset($trendingMessages) && count($trendingMessages) >= $rowsTTMessages): ?>
                    <?php foreach($trendingMessages as $key => $message): ?>
                        <div class="cmt-ctn">
                            <span class="comment">
                                <?php echo ( strlen($message["texto"]) >= 30 ? substr($message["texto"], 0, 30).'...' : $message["texto"]) ?>
                                <br>
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $message["nombreusuario"]?>&menu_opt=posts" style="text-decoration: underline">leer mas</a>
                            </span>
                        </div>    
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="cmt-ctn">
                        <span class="comment">Mensaje destacado por defecto.</span>
                    </div>
                    <div class="cmt-ctn">
                        <span class="comment">Mensaje destacado por defecto.</span>
                    </div>
                    <div class="cmt-ctn">
                        <span class="comment">Mensaje destacado por defecto.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="trending-users-content">
        <div class="users-center-content fx fx-column fx-ai-ctr">
            <div class="trending-title">
                <h2>Usuarios destacados</h2>
            </div>
            <div class="fx fx-jc-ctr">
                <div class="user-trend-cnt fx fx-column fx-jc-sa">
                    <?php if(isset($trendingUsers) && count($trendingUsers) >= $rowsTTUsers): ?>
                        <?php foreach($trendingUsers as $key => $user): ?>
                            <div class="fx fx-ai-ctr">
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user->getUsername()?>&menu_opt=posts">
                                    <div class="user-logo-container" style="width: 40px">
                                        <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user->getId()?>" alt="user image">
                                    </div>
                                </a>
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user->getUsername()?>&menu_opt=posts">
                                    <div class="user-trend-username">
                                        <span style="font-size: 14px">@<?php echo $user->getUsername()?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach;?>
                    <?php else: ?>
                        <div class="fx fx-jc-ctr fx-ai-ctr">
                            <div class="user-logo">
                                <div class="box-icon-example"></div>
                            </div>
                            <div class="user-trend-username">
                                <span>@default</span>
                            </div>
                        </div>
                        <div class="fx fx-jc-ctr fx-ai-ctr">
                            <div class="user-logo">
                                <div class="box-icon-example"></div>
                            </div>
                            <div class="user-trend-username">
                                <span>@default</span>
                            </div>
                        </div>
                        <div class="fx fx-jc-ctr fx-ai-ctr">
                            <div class="user-logo">
                                <div class="box-icon-example"></div>
                            </div>
                            <div class="user-trend-username">
                                <span>@default</span>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </section>
</section>