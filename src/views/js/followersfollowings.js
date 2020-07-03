
import {
    sendAjaxRequest
} from './modal-helper.js';

const user_id = document.querySelector('#user_id_input').value;
const profile = document.querySelector('#profile_input').value;
let followsContainer = document.querySelector('#follows-container');

let fdata = new FormData();
fdata.append('user_id', user_id);
fdata.append('profile', profile);
sendAjaxRequest('controllers/ajax/followersfollowings.controller.php', 'POST', fdata, (response) => {
    if(response.status == 200){
        let users = JSON.parse(response.body);
        addUsersToDom(users);

        manageButtons();
    }else {
        console.error("error en seguimiento.");
    }
});


function addUsersToDom(users){


    users.forEach((user) => {
        let template = `
        <div class="follows-layout-content fx fx-ai-ctr">
    
            <div class="left-layout-content fx fx-jc-ctr fx-ai-ctr">
    
                <!-- IMAGEN DE USUARIO -->
                <a href="http://localhost/phpseminario/src?page=profile&username=${user.nombreusuario}">
                    <div class="user-logo-container">
                        <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=${user.id}" alt="user image">
                    </div>
                </a>
            </div>
    
            <div class="right-layout-content">
    
                <div class="top-content-post fx fx-jc-btw fx-ai-ctr">
    
                    <div class="user-username-content fx fx-column">
                        <!-- NOMBRE DE USUARIO -->
                        <div class="post-user-name">
                            <a href="http://localhost/phpseminario/src?page=profile&username=${user.nombreusuario}">
                                <span>${user.nombre + ' ' + user.apellido}</span>
                            </a>
                        </div>
                        <!-- USERNAME DE USUARIO -->
                        <div class="post-user-username">
                            <span>${user.nombreusuario}</span>
                        </div>
    
                    </div>
    
                    <div class="btn btn-primary btn-follows ${user.is_following}-button" user_owner="${user_id}" user_host="${user.id}" is_following="${user.is_following}">siguiendo</div>
    
                </div>
    
            </div>
    
        </div>`;
    
        followsContainer.innerHTML += template;
    });

}

function manageButtons(){
    let buttons = document.querySelectorAll('.btn-follows');

    buttons.forEach((button) => {
        let owner_id = button.getAttribute("user_owner");
        let host_id = button.getAttribute("user_host");
        let is_following = button.getAttribute("is_following");

        if(is_following == "followingme"){
            button.innerText = 'Siguiendo';
            button.addEventListener('mouseover', buttonStyleFollow(button));
        }else if(is_following == "notfollowingme"){
            button.innerText = 'Seguir';
        }else if(is_following == "followingyou"){
            button.innerText = 'Siguiendo';
        }else if(is_following == "notfollowingyou"){
            button.innerText = 'Seguir';
        }


        button.addEventListener('click', () => {

            
            
        });

        console.log(owner_id, host_id, is_following)
    });
}

function buttonStyleFollow(button){
    button.innerText = 'Dejar de seguir';
}