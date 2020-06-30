import {
    createModal,
    validateEmail,
    validatePassword,
    setFlickingMessage,
    printMessage
} from './modal-helper.js';

let template = 
`
<div class="main-container-cmt fx fx-column fx-ai-ctr">
    <div class="top-content-cmt fx fx-ai-ctr fx-jc-btw">

        <div class="padding-top"></div>

        <div class="web-logo-content">
            <img src="views/img/logo-white.png" class="logo-web" alt="">
        </div>
        
        <div class="padding-top"></div>

    </div>
    <div class="commentary-content-large fx fx-jc-ctr fx-ai-ctr">

        <div class="comment-center fx fx-column fx-jc-sa">
            <div class="fx fx-jc-ctr">
                <div class="user-logo">
                    <div class="box-user-logo-example">
                    </div>
                </div>
                <div class="user-commentary-content">
                    <textarea class="input-commentary" placeholder="en que estas pensando?"></textarea>
                </div>
            </div>
            <div class="menu-comment-content fx fx-jc-sa fx-ai-ctr">
                <div class="upload-file">
                    <div class="icon-picture"></div>
                    <input id="upload-image-input" type="file" />
                </div>


                <div class="upload-file">
                    <div class="icon-smile"></div>    
                    <input id="upload-icon-input" type="file" name="icon-input"/>
                </div>
            </div>

            </div>
        </div>
        
        <div class="btn btn-primary btn-send-commentary" id="btn-send-cmt">
            Comentar
        </div>
        
            
</div>
`

let btnCommentary = document.querySelector("#btn-cmt");
let modal = createModal(template);


btnCommentary.addEventListener('click', () => {
    modal.printModal();
    modal.container.style = 'background-color: rgba(255,255,255,0.3)'

    let btnSendCmt = modal.content.querySelector('#btn-send-cmt');

    btnSendCmt.addEventListener('click', () => {
        console.log("mensaje enviado");
    });

    modal.container.addEventListener('click', (e) => {
        if (e.target == modal.container) {
            modal.removeModal();
        }
    });
});