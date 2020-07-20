import {
    createModal
} from './modal-helper.js';

import {
    postManager
} from './post.js';

const user_session_id = document.querySelector("#user_session_id_input").value;

let template = 
`
<div class="main-container-cmt fx fx-column fx-ai-ctr" id="main-container-modal">
    <div class="top-content-cmt fx fx-ai-ctr fx-jc-btw">

        <div class="padding-top"></div>

        <div class="web-logo-content">
            <img src="views/img/logo-white.png" class="logo-web" alt="">
        </div>
        
        <div class="padding-top"></div>

    </div>
    <div class="commentary-content-modal fx fx-jc-ctr fx-ai-ctr" id="modal-post-container">

        <div class="comment-center fx fx-column fx-jc-sa">
            <div class="fx fx-jc-ctr">
                <div class="user-logo">
                    <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=${user_session_id}" alt="user image" style="max-width: 50px; max-height: 50px; border-radius: 100%;">
                </div>
                <div class="user-commentary-content">
                    <textarea class="input-commentary" name="post-commentary" id="input-post-commentary" placeholder="en que estas pensando?"></textarea>
                </div>
            </div>

            <div class="menu-comment-content fx fx-jc-sa fx-ai-ctr">

                <div class="menu-comment-left-buttons fx fx-ai-ctr" id="menu_comment_post">
                    <input type="file" name="post-image" id="upload-post-image-modal" style="display: none;">
                    <label for="upload-post-image-modal">
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
        
    </div>
</div>
`

let btnCommentary = document.querySelector("#btn-cmt");

btnCommentary.addEventListener('click', () => {
    let modal = createModal(template);
    modal.printModal();
    modal.container.style = 'background-color: rgba(255,255,255,0.3)'

    let modalContainerEl = document.querySelector("#modal-post-container");

    postManager("modal", modalContainerEl);

    modal.container.addEventListener('click', (e) => {
        if (e.target == modal.container) {
            modal.removeModal();
        }
    });
});