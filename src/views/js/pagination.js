import {
    sendAjaxRequest
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

let origin = 0;
const rows = 10;
var fired = false;

getPosts(page);

window.addEventListener('scroll', () => {

    if(!fired){
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        
        if(clientHeight + scrollTop >= scrollHeight - 5) {

            fired = true;
            getPosts(page);
            
        }
    }
    
});

function getPosts(resource){
    let fdata = new FormData();
    fdata.append('user_id', user_id);
    fdata.append('origin', origin);
    fdata.append('rows', rows);
    fdata.append('page', resource);
    sendAjaxRequest('controllers/ajax/postpagination.controller.php', 'POST', fdata, (response) => {

        if(response.status == 200){
            let posts = JSON.parse(response.body);
            if(posts.length > 0){
                origin += posts.length;
                addPostToDom(posts);
                manageLikes();
                manageRemovePost();
            }
        }else {
            console.error('error paginacion');
        }

        setTimeout(() => {
            fired = false;
        }, 1000);

    });
}




function addPostToDom(posts){

    let postsContainer = document.querySelector('#posts-container');

    posts.forEach((post) => {

        let template = `<div class="post-layout-content fx">
    
        <div class="left-layout-content fx fx-jc-ctr">

            <!--LOGO DE USUARIO-->

            <a href="http://localhost/phpseminario/src?page=profile&username=${post.nombreusuario_user}">
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
                        <a href="http://localhost/phpseminario/src?page=profile&username=${post.nombreusuario_user}">
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

        postsContainer.innerHTML += fullTemplate;
        
        
    });

}
