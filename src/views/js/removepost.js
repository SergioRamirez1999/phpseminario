window.onload = function() {

    let removePostEl = document.querySelectorAll('.remove-message');

    if(removePostEl != undefined){
        removePostEl.forEach((elem) => {
            elem.addEventListener('click', () => {
                let id_message = elem.getAttribute('message_id');
                if(id_message){
                    let xhr = new XMLHttpRequest;
                    let fdata = new FormData();
                    fdata.append('id_message', id_message);
                    xhr.onreadystatechange = function() {
                        if(xhr.readyState == 4){
                            if(xhr.status == 200){
                                let response = JSON.parse(xhr.responseText);
                                if(response.status == 200){
                                    console.log(response.message)
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
        })
    }
}