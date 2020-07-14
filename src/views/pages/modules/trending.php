<?php

    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){
        $messageController = new MessageController();

        $trendingMessages = $messageController->getTrending(3);

    }else {
        session_destroy();
        header("Location: http://localhost/phpseminario/src");
    }

?>
<section class="right-content fx fx-column fx-ai-ctr">
    <div class="browser-content fx">
        <div class="browser-center-content fx fx-jc-ctr fx-ai-ctr">
            <div class="icon-search">

            </div>
            <input class="input-search-brw input-search"  type="text" placeholder="personas, keywords">
        </div>
    </div>

    <script type="module" src="views/js/search.js"></script>

    <section class="trending-comments-content">
        <div class="comments-center-content">

            <div class="trending-title">
                <h2>Comentarios destacados</h2>
            </div>
            <div class="comments-content fx fx-column">

                <?php if(isset($trendingMessages) && count($trendingMessages) >= 3): ?>

                    <?php foreach($trendingMessages as $key => $element): ?>
                        <div class="cmt-ctn">
                            <span class="comment">
                                <?php echo ( strlen($element["texto"]) >= 30 ? substr($element["texto"], 0, 30).'...' : $element["texto"]) ?>
                                <br>
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element["nombreusuario"] ?>" style="text-decoration: underline">leer mas</a>
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

            <div class="user-trend-cnt fx fx-column fx-jc-sa">

                <div class="fx fx-jc-ctr fx-ai-ctr">


                    <div class="user-logo">
                        <div class="box-icon-example"></div>
                    </div>
                    <div class="user-trend-username">
                        <span>fmsanti</span>
                    </div>

                </div>

                <div class="fx fx-jc-ctr fx-ai-ctr">


                    <div class="user-logo">
                        <div class="box-icon-example"></div>
                    </div>
                    <div class="user-trend-username">
                        <span>fmsanti</span>
                    </div>

                </div>


                <div class="fx fx-jc-ctr fx-ai-ctr">


                    <div class="user-logo">
                        <div class="box-icon-example"></div>
                    </div>
                    <div class="user-trend-username">
                        <span>fmsanti</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


</section>