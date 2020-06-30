
function postManager(){

    const txtAreaEl = document.querySelector('#input-post-commentary');
    const charsIndicatorEl = document.querySelector('#cmt-limit-indicator');

    
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
    
    
    let uploadImage = document.querySelector('#upload-post-image');

    uploadImage.addEventListener('change', () => {

        let menuCommentEl = document.querySelector('#menu_comment_post');

        if(uploadImage.files.length > 0){
            let filename = uploadImage.files[0].name;
            if(menuCommentEl.querySelector('#filename-tag') == undefined){
                menuCommentEl.innerHTML +=
                `<div class="file-to-upload fx fx-ai-ctr" id="filename-tag">
                    <span class="file-name" id="input_file_name">${filename}</span>
                    <div class="file-remove-btn">x</div>
                </div>`
    
                document.querySelector('#filename-tag').addEventListener('click', () => {
                    uploadImage.value = '';
                    menuCommentEl.removeChild(menuCommentEl.querySelector('#filename-tag'));
                });
            }
        }
    })

    const btnSendPost = document.querySelector('#btn-send-post');

    btnSendPost.addEventListener('click', () => {
        if(txtAreaEl.textLength > minLength && txtAreaEl.textLength <= maxLength){

            if(uploadImage.files.length > 0)
                sendPost(txtAreaEl.value, uploadImage.files[0]);
            else
                sendPost(txtAreaEl.value);

        }
    });
    
}

function sendPost(commentary, image = null){

    let xhr = new XMLHttpRequest;
    let fdata = new FormData();
    fdata.append('post-commentary', commentary);

    if(image != null)
        fdata.append('post-image', image);

    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                let response = JSON.parse(xhr.responseText);

                if(response.status == 200){
                    console.log(response.message);
                    document.querySelector('#input-post-commentary').value = '';
                    document.querySelector('#cmt-limit-indicator').innerText = '0/140';
                    document.querySelector('#cmt-limit-indicator').style = "color: grey";
                    document.querySelector('#upload-post-image').value = '';
                }else {
                    console.error(response.message);
                }
            }
        }
    }
    xhr.open('POST', 'controllers/ajax/postpublication.controller.php');
    xhr.send(fdata);

}

postManager();
