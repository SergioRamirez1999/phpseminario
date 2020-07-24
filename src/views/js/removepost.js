export function manageRemovePost(posts) {

    posts.forEach((element) => {

        let removeEl = element.querySelector('.remove-message');

        if(removeEl != undefined){
            removeEl.addEventListener('click', () => {
                let id_message = removeEl.getAttribute('message_id');
                if(id_message){
                    let xhr = new XMLHttpRequest;
                    let fdata = new FormData();
                    fdata.append('id_message', id_message);
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState == 4){
                            if(xhr.status == 200){
                                let response = JSON.parse(xhr.responseText);
                                if(response.status == 200){
                                    let postContainerEl = removeEl.parentNode.parentNode.parentNode.parentNode;
                                    postContainerEl.parentNode.removeChild(postContainerEl);
                                }else {
                                    console.error(response.message);
                                }
                            }
                        }
                    }
                    xhr.open('POST', 'controllers/ajax/postremove.controller.php');
                    xhr.send(fdata);
                }
        
            });
        }

    })
}
