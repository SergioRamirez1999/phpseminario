
import {
    sendAjaxRequest
} from './modal-helper.js';


export function manageLikes() {

    let c_likes = document.querySelectorAll('.likes-counter-container');

    c_likes.forEach((element) => {
        let hasListener = element.getAttribute("listener");
        if(hasListener == undefined){
            element.setAttribute("listener", "true");

            element.addEventListener('click', () => {
                let user_id = element.getAttribute("user_id");
                let post_id = element.getAttribute("post_id");
                let is_liked = element.getAttribute("is_liked");
    
                if(user_id && post_id && is_liked){
                    let fdata = new FormData();
                    fdata.append('user_id', user_id);
                    fdata.append('post_id', post_id);
                    fdata.append('is_liked', is_liked);
                    sendAjaxRequest('controllers/ajax/postlikes.controller.php', 'POST', fdata, (response) => {
                        if(response.status == 200){
                            if(is_liked == "unliked"){
                                element.classList.remove("unliked-opt-container");
                                element.classList.add("liked-opt-container");
                                element.setAttribute("is_liked", "liked");
                                let counter = element.querySelector('.likes-counter');
                                counter.innerText = parseInt(counter.innerText) + 1;
                                
                            }else if(is_liked == "liked"){
                                element.classList.remove("liked-opt-container");
                                element.classList.add("unliked-opt-container");
                                element.setAttribute("is_liked", "unliked");
                                let counter = element.querySelector('.likes-counter');
                                counter.innerText = parseInt(counter.innerText) - 1;
                            }
                        }else {
                            console.error("error");
                        }
    
                    });
                }else {
                    console.error('error');
                }
    
                
            });
        }
        
    });

}



manageLikes();