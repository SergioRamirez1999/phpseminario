
import {
    sendAjaxRequest
} from './modal-helper.js';


export function manageLikes(posts) {

    posts.forEach((element) => {

        let likesEl = element.querySelector('.likes-counter-container');

        likesEl.addEventListener('click', () => {
            let user_id = likesEl.getAttribute("user_id");
            let post_id = likesEl.getAttribute("post_id");
            let is_liked = likesEl.getAttribute("is_liked");

            if(user_id && post_id && is_liked){
                let fdata = new FormData();
                fdata.append('user_id', user_id);
                fdata.append('post_id', post_id);
                fdata.append('is_liked', is_liked);
                sendAjaxRequest('controllers/ajax/postlikes.controller.php', 'POST', fdata, (response) => {
                    if(response.status == 200){
                        if(is_liked == "unliked"){
                            likesEl.classList.remove("unliked-opt-container");
                            likesEl.classList.add("liked-opt-container");
                            likesEl.setAttribute("is_liked", "liked");
                            let counter = likesEl.querySelector('.likes-counter');
                            counter.innerText = parseInt(counter.innerText) + 1;
                        }else if(is_liked == "liked"){
                            likesEl.classList.remove("liked-opt-container");
                            likesEl.classList.add("unliked-opt-container");
                            likesEl.setAttribute("is_liked", "unliked");
                            let counter = likesEl.querySelector('.likes-counter');
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
        
    });

}
