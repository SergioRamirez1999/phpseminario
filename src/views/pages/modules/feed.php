<?php

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){
        $user = $_SESSION["user_data"];

        $postsFollowings = UserController::getFollowingsPosts($user["id"]);

        $postsUser = UserController::getPostsById($user["id"]);

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
                    <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user["id"]?>" alt="user image" style="max-width: 50px; max-height: 50px; border-radius: 100%;">
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

    <div class="post-general-content">


        <?php if(count($postsUser) > 0): ?>
            <div class="post-layout-content fx">

                <div class="left-layout-content fx fx-jc-ctr">

                    <!--LOGO DE USUARIO-->

                    <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user["nombreusuario"] ?>">
                        <div class="user-logo-container">
                            <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $user["id"]?>" alt="user image">
                        </div>
                    </a>

                </div>


                <div class="right-layout-content">

                    <div class="top-content-post">

                        <div class="user-username-content fx fx-jc-btw fx-ai-ctr">

                            
                            <div class="lft-ct fx fx-ai-ctr">
                                <!--NOMBRE Y APELLIDO DE USUARIO -->
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $user["nombreusuario"] ?>">
                                    <div class="post-user-name">
                                        <span><?php echo $user["nombre"].' '.$user["apellido"]?></span>
                                    </div>
                                </a>

                                <!--USERNAME DE USUARIO -->
                                <div class="post-user-username">
                                    <span>&nbsp;<?php echo '@'.$user["nombreusuario"]?></span>
                                </div>

                                <!--FECHA MENSAJE -->
                                <div class="post-fecha">
                                    <span><?php echo '~'.$postsUser["0"]["fechayhora"] ?></span>
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
                                <span><?php echo $postsUser[0]["texto"]?></span>
                            </div>

                            <br>

                        </div>

                        <?php if(isset($postsUser[0]["imagen_contenido"]) && $postsUser[0]["imagen_contenido"] != null):?>
                            <div class="image-post-container fx fx-jc-ctr">
                                <img src="controllers/ajax/imagepreview.controller.php?image_type=message&id_message=<?php echo $postsUser[0]["id"] ?>" alt="post image">
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php
                        $likes = UserController::getLikesByPostId($postsUser[0]["id"]);
                        $c_likes = count($likes);

                        $id_likes = array_map(function($like){
                            return $like["usuarios_id"];
                        }, $likes);

                        $liked = in_array($user["id"], $id_likes);

                    ?>

                    <!--LIKES/RETWEETS-->
                    <div class="bottom-content-post fx">
                        <div class="menu-option fx fx-ai-ctr">
                            <?php if(isset($liked) && $liked):?>
                                <div class="liked-opt-container likes-counter-container fx fx-ai-ctr" user_id="<?php echo $user["id"]?>" post_id="<?php echo $postsUser[0]["id"]?>" is_liked="true">
                                    <div class="icon-heart likes-counter-icon"></div>
                                    <span class="likes-counter"><?php echo $c_likes?></span>
                                </div>
                            <?php else:?>
                                <div class="unliked-opt-container likes-counter-container fx fx-ai-ctr" user_id="<?php echo $user["id"]?>" post_id="<?php echo $postsUser[0]["id"]?>" is_liked="false">
                                    <div class="icon-heart likes-counter-icon"></div>
                                    <span class="likes-counter"><?php echo $c_likes?></span>
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


        <!-- ####### POST 1 EXAMPLE #######-->

       <?php foreach($postsFollowings as $key=>$element): ?>
            <div class="post-layout-content fx">

                <div class="left-layout-content fx fx-jc-ctr">

                    <!--LOGO DE USUARIO-->
                    <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element["nombreusuario_user"] ?>">
                        <div class="user-logo-container">
                            <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=<?php echo $element["id_user"]?>" alt="user image" style="max-width: 50px; max-height: 50px; border-radius: 100%;">
                        </div>
                    </a>

                </div>


                <div class="right-layout-content">

                    <div class="top-content-post">

                        <div class="user-username-content fx fx-jc-btw fx-ai-ctr">

                            <div class="lft-ct fx fx-ai-ctr">
                                <!--NOMBRE Y APELLIDO DE USUARIO -->
                                <a href="http://localhost/phpseminario/src?page=profile&username=<?php echo $element["nombreusuario_user"] ?>">
                                    <div class="post-user-name">
                                            <span><?php echo $element["nombre_user"].' '.$element["apellido_user"]?></span>
                                    </div>
                                </a>

                                <!--USERNAME DE USUARIO -->
                                <div class="post-user-username">
                                    <span>&nbsp;<?php echo '@'.$element["nombreusuario_user"]?></span>
                                </div>

                                <!--FECHA MENSAJE -->
                                <div class="post-fecha">
                                    <span><?php echo '~'.$element["fechayhora_mensaje"] ?></span>
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
                                <span><?php echo $element["texto_mensaje"]?></span>
                            </div>

                            <br>

                        </div>

                        <?php if(isset($element["imagen_contenido_mensaje"]) && $element["imagen_contenido_mensaje"] != null):?>
                                <!--POST IMAGEN-->
                            <div class="image-post-container fx fx-jc-ctr">
                                <img src="controllers/ajax/imagepreview.controller.php?image_type=message&id_message=<?php echo $element["id_mensaje"] ?>" alt="post image">
                            </div>
                        <?php endif; ?>

                    </div>

                    <?php
                        $likes = UserController::getLikesByPostId($element["id_mensaje"]);
                        $c_likes = count($likes);

                        $id_likes = array_map(function($like){
                            return $like["usuarios_id"];
                        }, $likes);

                        $liked = in_array($user["id"], $id_likes);

                    ?>

                    <!--LIKES/RETWEETS-->
                    <div class="bottom-content-post fx">
                        <div class="menu-option fx fx-ai-ctr">
                            <?php if(isset($liked) && $liked):?>
                                <div class="liked-opt-container likes-counter-container fx fx-ai-ctr" user_id="<?php echo $user["id"]?>" post_id="<?php echo $element["id_mensaje"]?>" is_liked="true">
                                    <div class="icon-heart likes-counter-icon"></div>
                                    <span class="likes-counter"><?php echo $c_likes?></span>
                                </div>
                            <?php else:?>
                                <div class="unliked-opt-container likes-counter-container fx fx-ai-ctr" user_id="<?php echo $user["id"]?>" post_id="<?php echo $element["id_mensaje"]?>" is_liked="false">
                                    <div class="icon-heart likes-counter-icon"></div>
                                    <span class="likes-counter"><?php echo $c_likes?></span>
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
        <?php endforeach; ?>

        <script type="module" src="views/js/likes.js"> </script>

    </div>




</section>