import {
    sendAjaxRequest,
    printMessage,
    setFlickingMessage
} from './modal-helper.js';

import {
    manageLikes
} from './likes.js';

import {
    manageRemovePost
} from './removepost.js';

const user_id = document.querySelector('#user_id_input').value;
const user_session_id = document.querySelector('#user_session_id_input').value;
const page = document.querySelector('#page_input').value;

export function postManager(type = "feed", element = null){

    let txtAreaEl;
    let charsIndicatorEl;
    if(type == "feed"){
        txtAreaEl = document.querySelector('#input-post-commentary');
        charsIndicatorEl = document.querySelector('#cmt-limit-indicator');
    }else if(type == "modal" && element != null){
        txtAreaEl = element.querySelector("#input-post-commentary");
        charsIndicatorEl = element.querySelector('#cmt-limit-indicator');
    }

    let minLength = 0;
    let maxLength = 140;
    
    txtAreaEl.addEventListener('keyup', (e) => {
        if(txtAreaEl.textLength >= maxLength){
            charsIndicatorEl.style = "color: red";
        }else {
            charsIndicatorEl.style = "color: grey";
        }
        if(txtAreaEl.textLength > maxLength){
            txtAreaEl.value = txtAreaEl.value.substr(0, maxLength);
        }
        charsIndicatorEl.innerText = txtAreaEl.textLength+'/'+maxLength
    });
    
    let uploadImage;
    let menuCommentEl;
    if(type == "feed"){
        uploadImage = document.querySelector('#upload-post-image');
        menuCommentEl = document.querySelector('#menu_comment_post');
    }else if(type == "modal" && element != null){
        uploadImage = element.querySelector('#upload-post-image-modal');
        menuCommentEl = element.querySelector('#menu_comment_post');
    }

    uploadImage.addEventListener('change', () => {
        if(uploadImage.files.length > 0){
            let filename = uploadImage.files[0].name;
            if(menuCommentEl.querySelector('#filename-tag') == undefined){
                menuCommentEl.innerHTML +=
                `<div class="file-to-upload fx fx-ai-ctr" id="filename-tag">
                    <span class="file-name" id="input_file_name">${filename}</span>
                    <div class="file-remove-btn">x</div>
                </div>`

                if(type == "feed"){
                    document.querySelector('#filename-tag').addEventListener('click', () => {
                        uploadImage.value = '';
                        menuCommentEl.removeChild(menuCommentEl.querySelector('#filename-tag'));
                    });
                }else if(type == "modal" && element != null){
                    element.querySelector('#filename-tag').addEventListener('click', () => {
                        uploadImage.value = '';
                        menuCommentEl.removeChild(menuCommentEl.querySelector('#filename-tag'));
                    });
                }
            }
        }
    })

    let btnSendPost;
    if(type == "feed"){
        btnSendPost = document.querySelector('#btn-send-post');
    }else if(type == "modal" && element != null){
        btnSendPost = element.querySelector('#btn-send-post');
    }

    btnSendPost.addEventListener('click', () => {
        if(txtAreaEl.textLength > minLength && txtAreaEl.textLength <= maxLength){

            if(uploadImage.files.length > 0)
                sendPost(txtAreaEl.value, uploadImage.files[0], type, element);
            else
                sendPost(txtAreaEl.value, null, type, element);

        }
    });
    
}

export function sendPost(commentary, image = null, type="feed", element=null){

    let fdata = new FormData();
    fdata.append('post-commentary', commentary);

    if(image != null)
        fdata.append('post-image', image);

    sendAjaxRequest('controllers/ajax/postpublication.controller.php', 'POST', fdata, (response) => {
        if(response.status == 200){
            let post = JSON.parse(response.body);
            let newPost;
            if(type == "feed"){
                document.querySelector('#input-post-commentary').value = '';
                document.querySelector('#cmt-limit-indicator').innerText = '0/140';
                document.querySelector('#cmt-limit-indicator').style = "color: grey";
                document.querySelector('#upload-post-image').value = '';
                if(document.querySelector('#filename-tag') != undefined)
                    document.querySelector('#filename-tag').parentNode.removeChild(document.querySelector('#filename-tag'));
                newPost = addPost(post);
            }else if(type == "modal" && element != null){

                if((page == "profile" && user_id != user_session_id) || page == "follows" || page == "search"){
                    let username = document.querySelector("#user_session_username_input").value;
                    window.location = `http://localhost/phpseminario/src?page=profile&username=${username}&menu_opt=posts`
                    return;
                }

                element.querySelector('#input-post-commentary').value = '';
                element.querySelector('#cmt-limit-indicator').innerText = '0/140';
                element.querySelector('#cmt-limit-indicator').style = "color: grey";
                element.querySelector('#upload-post-image-modal').value = '';
                if(element.querySelector('#filename-tag') != undefined)
                    element.querySelector('#filename-tag').parentNode.removeChild(element.querySelector('#filename-tag'));

                if(document.querySelector('#main-container-modal').getElementsByClassName('success-message')[0] == undefined){
                    printMessage('main-container-modal', response.message, 'success')
                    setFlickingMessage(document.querySelector('#main-container-modal').getElementsByClassName('success-message')[0]);
                    setTimeout(() => {
                        if(document.querySelector('#main-container-modal') != undefined){
                            document.querySelector('#main-container-modal').removeChild(document.querySelector('#main-container-modal').getElementsByClassName('success-message')[0]);
                        }
                    }, 3500);
                }
                
                newPost = addPost(post);
            }

            manageLikes(newPost);
            manageRemovePost(newPost);

        }else {
            console.error(response.message);
        }
    });
}

function addPost(post){

    let postsContainer = document.querySelector('#posts-container');

    let template = `<div class="post-layout-content fx">
    
        <div class="left-layout-content fx fx-jc-ctr">

            <!--LOGO DE USUARIO-->

            <a href="http://localhost/phpseminario/src?page=profile&username=${post.nombreusuario_user}&menu_opt=posts">
                <div class="user-logo-container">
                    <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=${post.id_user}" alt="user image">
                </div>
            </a>

        </div>


        <div class="right-layout-content">

            <div class="top-content-post">

                <div class="user-username-content fx fx-jc-btw fx-ai-ctr">

                    
                    <div class="lft-ct fx fx-ai-ctr">
                        <!--NOMBRE Y APELLIDO DE USUARIO -->
                        <a href="http://localhost/phpseminario/src?page=profile&username=${post.nombreusuario_user}&menu_opt=posts">
                            <div class="post-user-name">
                                <span>${post.nombre_user + ' ' + post.apellido_user}</span>
                            </div>
                        </a>

                        <!--USERNAME DE USUARIO -->
                        <div class="post-user-username">
                            <span>&nbsp;@${post.nombreusuario_user}</span>
                        </div>

                        <!--FECHA MENSAJE -->
                        <div class="post-fecha">
                            <span>~${post.fechayhora_mensaje}</span>
                        </div>
                    </div>`


    let eliminarPost =
                `<!--EDITAR MENSAJE -->
                <div class="edit-post remove-message" message_id=${post.id_mensaje}>
                    <div>X</div>
                </div>

            </div>

        </div>

        <div class="between-content-post">

            <div class="commentary-content-post">
                <div class="commentary-content-msg">
                    <!--POST TEXTO-->
                    <span>${post.texto_mensaje}</span>
                </div>
            </div>`

    let editarPost =
            `<!--EDITAR MENSAJE -->
            <div class="edit-post">
                <div class="icon-down-open"></div>
            </div>

        </div>

    </div>

    <div class="between-content-post">

        <div class="commentary-content-post">
            <div class="commentary-content-msg">
                <!--POST TEXTO-->
                <span>${post.texto_mensaje}</span>
            </div>
        </div>`

    let imagen = `
            <!--POST IMAGEN-->
            <div class="image-post-container fx fx-jc-ctr">
                <img src="controllers/ajax/imagepreview.controller.php?image_type=message&id_message=${post.id_mensaje}" alt="post image">
            </div>`
        

    let like = `<!--LIKES/RETWEETS-->
        </div>
        <div class="bottom-content-post fx">
            <div class="menu-option fx fx-ai-ctr">
                <div class="${post.is_liked}-opt-container likes-counter-container fx fx-ai-ctr" user_id="${user_id}" post_id="${post.id_mensaje}" is_liked="${post.is_liked}">
                    <div class="icon-heart likes-counter-icon"></div>
                    <span class="likes-counter">${post.likes}</span>
                </div>
            </div>
            
        </div>

    </div>`


    let fullTemplate = template;

    if(page == "profile" && user_id == user_session_id){
        fullTemplate += eliminarPost
    }else {
        fullTemplate += editarPost
    }
    
    if(post.imagen_contenido){
        fullTemplate += imagen;
    }

    fullTemplate += like;

    var templateEl = document.createElement('template');
    fullTemplate = fullTemplate.trim();
    templateEl.innerHTML = fullTemplate;
    
    let newPosts = [];
    newPosts.push(templateEl.content.firstChild);

    setFlickingMessage(templateEl.content.firstChild);
    postsContainer.insertBefore(templateEl.content.firstChild, postsContainer.firstChild);

    return newPosts;
    
}
