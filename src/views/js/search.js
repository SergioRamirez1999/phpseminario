import {
    sendAjaxRequest,
    printMessage,
} from './modal-helper.js';

const user_session_id = document.querySelector('#user_session_id_input').value;
let keyword = document.querySelector("#keyword_input").value;

let fdata = new FormData();
fdata.append('q', keyword);

sendAjaxRequest('controllers/ajax/search.controller.php', 'POST', fdata, (response) => {

    if(response.status == 200){
        let users = JSON.parse(response.body);

        if(users.length > 0){
            addUsersToDom(users);
            manageButtons();
        }else {
            let resultsContainer = document.querySelector("#results-container");
            resultsContainer.innerHTML += `<div> No se encontraron resultados para ${keyword}</div>`
        }

    }else {
        console.error(response.message);
    }
});

function addUsersToDom(users){

    let resultsContainer = document.querySelector("#results-container");

    users.forEach((user) => {
        let template = 
        `<div class="follows-layout-content fx fx-ai-ctr">
            <div class="left-layout-content fx fx-jc-ctr fx-ai-ctr">
                <a href="http://localhost/phpseminario/src?page=profile&username=${user.nombreusuario}&menu_opt=posts">
                    <div class="user-logo-container">
                        <img src="controllers/ajax/imagepreview.controller.php?image_type=user&id_user=${user.id}" alt="user image">
                    </div>
                </a>
            </div>
            <div class="right-layout-content">
                <div class="top-content-post fx fx-jc-btw fx-ai-ctr">
                    <div class="user-username-content fx fx-column">
                        <div class="post-user-name">
                            <a href="http://localhost/phpseminario/src?page=profile&username=${user.nombreusuario}&menu_opt=posts">
                                <span>${user.nombre+' '+user.apellido}</span>
                            </a>
                        </div>
                        <div class="post-user-username">
                            <span>${'@'+user.nombreusuario}</span>
                        </div>
                    </div>`
        let follow_template = 
                    `<div class="btn button-follow" style="margin-right: 5px" user_owner="${user_session_id}" user_host="${user.id}" is_following="${user.is_following}"></div>`
        
        let final_template = `
                </div>
            </div>
        </div>`;

        let fulltemplate = template;
        if(user.id != user_session_id)
            fulltemplate += follow_template;
        fulltemplate += final_template;
        
        resultsContainer.innerHTML += fulltemplate;

    });

}

function manageButtons(){

    let buttons = document.querySelectorAll('.button-follow');

    buttons.forEach((button) => {
        let owner_id = button.getAttribute("user_owner");
        let host_id = button.getAttribute("user_host");
        let is_following = button.getAttribute("is_following");

        function buttonFollowingOverStyle(){
            button.innerText = 'Dejar de seguir';
            button.style = 'background-color: rgb(210, 28, 56);margin-right: 5px;';
        }

        function buttonFollowingOutStyle(){
            button.innerText = 'Siguiendo';
            button.style = 'background-color: rgb(29, 161, 242);margin-right: 5px;';
        }

        function buttonFollowOverStyle(){
            button.style = 'background-color: rgba(29, 161, 242, 0.7);margin-right: 5px;';
        }
        
        function buttonFollowOutStyle(){
            button.style = 'background-color: rgb(29, 161, 242);margin-right: 5px;';
        }

        if(is_following == "true"){
            button.innerText = "Siguiendo";
            button.addEventListener('mouseover', buttonFollowingOverStyle);
            button.addEventListener('mouseout', buttonFollowingOutStyle);
        }else {
            button.innerText = "Seguir";
            button.addEventListener('mouseover', buttonFollowOverStyle);
            button.addEventListener('mouseout', buttonFollowOutStyle);
        }

        button.addEventListener('click', () => {
            let fdata = new FormData();
            fdata.append('user_id', owner_id);
            fdata.append('user_id_fu', host_id);
            fdata.append('is_following', is_following);

            sendAjaxRequest('controllers/ajax/followunfollow.controller.php', 'POST', fdata, (response) => {

                if(response.status == 200){
                    if(is_following == "true"){
                        is_following = "false";
                        button.setAttribute("is_following", is_following);
                        button.removeEventListener('mouseover', buttonFollowingOverStyle);
                        button.removeEventListener('mouseout', buttonFollowingOutStyle);
                        button.innerText = 'Seguir';
                        button.addEventListener('mouseover', buttonFollowOverStyle);
                        button.addEventListener('mouseout', buttonFollowOutStyle);
                    }else if(is_following == "false"){
                        is_following = "true";
                        button.setAttribute("is_following", is_following);
                        button.removeEventListener('mouseover', buttonFollowOverStyle);
                        button.removeEventListener('mouseout', buttonFollowOutStyle);
                        button.innerText = 'Siguiendo';
                        button.addEventListener('mouseover', buttonFollowingOverStyle);
                        button.addEventListener('mouseout', buttonFollowingOutStyle);
                    }
                }
            });
        });

    });
}