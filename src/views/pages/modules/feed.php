<?php
    require_once ROOT_DIR."/models/user.entity.php";
    require_once ROOT_DIR."/controllers/user.controller.php";
    require_once ROOT_DIR."/controllers/message.controller.php";
    require_once ROOT_DIR."/controllers/like.controller.php";

    if(session_status() == PHP_SESSION_NONE)
        session_start();
    
    if(isset($_SESSION["user_data"])){
        $user = $_SESSION["user_data"];

        $userController = new UserController();

        $postUser = $userController->getPaginationMessages($user->getId(), 0, 1);

    }else {
        session_destroy();
        header("Location: http://localhost/phpseminario/src");
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
        
    </div>

    <script type="module">
        import {
            postManager
        } from "./views/js/post.js";

        postManager();
    </script>


    <input type="hidden" value="<?php echo $user->getId()?>" id="user_session_id_input">
    <input type="hidden" value="<?php echo $user->getId()?>" id="user_id_input">
    <input type="hidden" value="home" id="page_input">

    <script type="module" src="views/js/pagination.js"> </script>
    <script type="module" src="views/js/likes.js"> </script>


</section>