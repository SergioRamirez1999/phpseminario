import {
    sendAjaxRequest,
    printMessage,
    setFlickingMessage
} from './modal-helper.js';

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
            if(type == "feed"){
                document.querySelector('#input-post-commentary').value = '';
                document.querySelector('#cmt-limit-indicator').innerText = '0/140';
                document.querySelector('#cmt-limit-indicator').style = "color: grey";
                document.querySelector('#upload-post-image').value = '';
                document.querySelector('#filename-tag').parentNode.removeChild(document.querySelector('#filename-tag'));
            }else if(type == "modal" && element != null){
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
            }
            
        }else {
            console.error(response.message);
        }
    });
}
