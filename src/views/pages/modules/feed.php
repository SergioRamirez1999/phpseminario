<?php
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){
        $user = $_SESSION["user_data"];

        $userController = new UserController();

        //obtener solo un post propio
        $postUser = $userController->getPaginationMessages($user->getId(), 0, 1);


    }else {
        echo '<script> window.location.href = "http://localhost/phpseminario/src"</script>';
    }
?>

<!--EL CENTRO SE QUEDA SI NO HAY SIZE-->
<section class="between-content">

    <div class="commentary-content fx fx-jc-ctr fx-ai-ctr">

        <div class="comment-center fx fx-column fx-jc-sa">
            <div class="fx fx-jc-ctr">
                <div class="user-logo">
                    <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user->getId()?>" alt="user image" style="max-width: 50px; max-height: 50px; border-radius: 100%;">
                </div>
                <div class="user-commentary-content">
                    <textarea class="input-commentary" name="post-commentary" id="input-post-commentary" placeholder="en que estas pensando?"></textarea>
                </div>
            </div>

            <div class="menu-comment-content fx fx-jc-sa fx-ai-ctr">

                <div class="menu-comment-left-buttons fx fx-ai-ctr" id="menu_comment_post">
                    <input type="file" name="post-image" id="upload-post-image" style="display: none;">
                    <label for="upload-post-image">
                        <div class="icon-picture" style="cursor: pointer;"></div>
                    </label>

                    <div class="icon-smile" id="emojis-btn" style="cursor: pointer;"></div>

                </div>

                
                <div class="menu-comment-rigth-buttons fx fx-jc-sa fx-ai-ctr">
                    <span class="commentary-characters" id="cmt-limit-indicator">0/140</span>
                    <div class="btn btn-primary" id="btn-send-post" style="align-self: flex-end;">Comentar</div>
                </div>

            </div>

        </div>

        <script type="module" src="views/js/post.js"></script>
    </div>

    <div class="post-general-content" id="posts-container">


        <?php if(isset($postUser) && count($postUser) > 0): ?>
            <div class="post-layout-content fx">

                <div class="left-layout-content fx fx-jc-ctr">

                    <!--LOGO DE USUARIO-->

                    <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user->getUsername() ?>">
                        <div class="user-logo-container">
                            <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user->getId()?>" alt="user image">
                        </div>
                    </a>

                </div>


                <div class="right-layout-content">

                    <div class="top-content-post">

                        <div class="user-username-content fx fx-jc-btw fx-ai-ctr">

                            
                            <div class="lft-ct fx fx-ai-ctr">
                                <!--NOMBRE Y APELLIDO DE USUARIO -->
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user->getUsername() ?>">
                                    <div class="post-user-name">
                                        <span><?php echo $user->getName().' '.$user->getLastname()?></span>
                                    </div>
                                </a>

                                <!--USERNAME DE USUARIO -->
                                <div class="post-user-username">
                                    <span>&nbsp;<?php echo '@'.$user->getUsername()?></span>
                                </div>

                                <!--FECHA MENSAJE -->
                                <div class="post-fecha">
                                    <span><?php echo '~'.$postUser[0]->getCreateAt() ?></span>
                                </div>
                            </div>


                            <!--EDITAR MENSAJE -->
                            <div class="edit-post">
                                <div class="icon-down-open"></div>
                            </div>

                        </div>

                    </div>

                    <div class="between-content-post">

                        <div class="commentary-content-post">
                            <div class="commentary-content-msg">
                                <!--POST TEXTO-->
                                <span><?php echo $postUser[0]->getText()?></span>
                            </div>

                            <br>

                        </div>

                        <?php if($postUser[0]->getImageContent() != null):?>
                            <div class="image-post-container fx fx-jc-ctr">
                                <img src="controllers/ajax/imagepreview.controller.php?image_type=message&id_message=<?php echo $postUser[0]->getId() ?>" alt="post image">
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php
                        $messageController = new MessageController();
                        $likes = $messageController->getById($postUser[0]->getId())->getLikes();
                    ?>

                    <!--LIKES/RETWEETS-->
                    <div class="bottom-content-post fx">
                        <div class="menu-option fx fx-ai-ctr">
                            <?php if(isset($liked) && $liked):?>
                                <div class="liked-opt-container likes-counter-container fx fx-ai-ctr" user_id="<?php echo $user->getId()?>" post_id="<?php echo $postUser[0]->getId()?>" is_liked="liked">
                                    <div class="icon-heart likes-counter-icon"></div>
                                    <span class="likes-counter"><?php echo $likes?></span>
                                </div>
                            <?php else:?>
                                <div class="unliked-opt-container likes-counter-container fx fx-ai-ctr" user_id="<?php echo $user->getId()?>" post_id="<?php echo $postUser[0]->getId()?>" is_liked="unliked">
                                    <div class="icon-heart likes-counter-icon"></div>
                                    <span class="likes-counter"><?php echo $likes?></span>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="menu-option fx fx-ai-ctr">
                            <div class="icon-retweet"></div>
                            <span>0</span>
                        </div>
                    </div>

                </div>

            </div>
        <?php endif; ?>



    </div>
    
    <input type="hidden" value="<?php echo $user->getId()?>" id="user_session_id_input">
    <input type="hidden" value="<?php echo $user->getId()?>" id="user_id_input">
    <input type="hidden" value="home" id="page_input">

    <script type="module" src="views/js/pagination.js"> </script>
    <script type="module" src="views/js/likes.js"> </script>


</section>