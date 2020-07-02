import {
    createModal,
    validateName,
    validateLastname,
    validateEmail,
    sendAjaxRequest,
    validatePassword,
    setFlickingMessage,
    printMessage
} from './modal-helper.js';


const editMenuTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top"></div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>

            <div class="padding-top"></div>
        </div>

        <div class="fx fx-jc-ctr">
            <div class="form-container edit-container fx fx-column">

                <div class="row-input-content edit-row-content">
                    <span class="edit-opt" id="btn-edit-name">Cambiar nombre</span>
                </div>
                <div class="row-input-content edit-row-content">
                    <span class="edit-opt" id="btn-edit-lastname">Cambiar apellido</span>
                </div>
                <div class="row-input-content edit-row-content">
                    <span class="edit-opt" id="btn-edit-email">Cambiar email</span>
                </div>
                <div class="row-input-content edit-row-content">
                    <span class="edit-opt" id="btn-edit-picture">Cambiar imagen de perfil</span>
                </div>
                <div class="row-input-content edit-row-content">
                    <span class="edit-opt" id="btn-edit-password">Cambiar contraseña</span>
                </div>
            </div>
        </div>

    </div>`

const editNameTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-1">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar nombre</h2>
                </div>
                
                <form method="POST" class="fx fx-column" id="form-edit-name">
                    <div class="row-input-content" id="name-edit-container">
                        <label for="username-input" class="label-input">Nombre</label>
                        <div class="input-content">
                            <input type="text" name="username-input" id="input-edit-name">
                        </div>
                    </div>

                    
                    <div class="btn-content">
                        <button type="submit" class="btn btn-primary" id="btn-name-save">Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>`

const editLastnameTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-2">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar apellido</h2>
                </div>

                <form method="POST" class="fx fx-column" id="form-edit-lastname">
                    
                    <div class="row-input-content" id="lastname-edit-container">
                        <label for="lastname-input" class="label-input">Cambiar apellido</label>
                        <div class="input-content">
                            <input type="text" name="lastname-input" id="input-edit-lastname">
                        </div>
                    </div>

                    
                    <div class="btn-content">
                        <button type="submit" class="btn btn-primary" id="btn-lastname-save">Guardar</button>
                    </div>

                </form>

            </div>

        </div>
    </div>`

const editEmailTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-3">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar correo electronico</h2>
                </div>
                
                <form method="POST" class="fx fx-column" id="form-edit-email">
                    <div class="row-input-content" id="email-edit-container">
                        <label for="email-input" class="label-input">Correo electronico</label>
                        <div class="input-content">
                            <input type="email" name="email-input" id="input-edit-email">
                        </div>
                    </div>

                    
                    <div class="btn-content">
                        <button type="submit" class="btn btn-primary" id="btn-email-save">Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>`

const editPictureTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-4">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar foto de perfil</h2>
                </div>
                
                <form method="POST" enctype="multipart/form-data" class="fx fx-column" id="form-edit-picture">
                    <div class="up-img-container fx fx-column fx-ai-ctr fx-jc-btw">
                        <h3 class="form-title">Elige tu foto de perfil</h3>

                        <div class="upload-img-content">
                            <img src="#" id="actual_image_user" class="up-user-img" alt="upload user image">
                        </div>

                        <div>
                            <input type="file" name="user-image" id="input-user-image" style="display: none;">
                            <label for="input-user-image">
                                <div class="btn btn-primary">Subir</div>
                            </label>
                        </div>

                    </div>

                    
                    <div class="btn-content">
                        <button type="submit" class="btn btn-primary" id="btn-picture-save">Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>`

const editPasswordTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-5">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar contraseña</h2>
                </div>

                <form method="POST" class="fx fx-column" id="form-edit-password">
                
                    <div class="row-input-content" id="password-actual-edit-container">
                        <label for="actual-password-input" class="label-input">Contraseña actual</label>
                        <div class="input-content">
                            <input type="password" name="actual-password-input" id="input-edit-password-actual">
                        </div>
                    </div>
                    
                    <div class="row-input-content" id="password-new-edit-container">
                        <label for="new-password-input" class="label-input">Nueva contraseña</label>
                        <div class="input-content">
                            <input type="password" name="new-password-input" id="input-edit-password-new">
                        </div>
                    </div>
                    
                    <div class="row-input-content" id="password-repeted-edit-container">
                        <label for="repeted-password-input" class="label-input">Repetir contraseña</label>
                        <div class="input-content">
                            <input type="password" name="repeted-password-input" id="input-edit-password-repeted">
                        </div>
                    </div>

                    
                    <div class="btn-content">
                        <button type="submit" class="btn btn-primary" id="btn-password-save">Guardar</button>
                    </div>
                </form>

            </div>

        </div>
    </div>`

const btnEditUser = document.getElementById('btn-edit-user');

if(btnEditUser != undefined){

    const modalEditMenu = createModal(editMenuTemplate);
    const modalEditName = createModal(editNameTemplate);
    const modalEditLastname = createModal(editLastnameTemplate);
    const modalEditEmail = createModal(editEmailTemplate);
    const modalEditPassword = createModal(editPasswordTemplate);
    const modalEditPicture = createModal(editPictureTemplate);

    const modals = [];
    modals.push(modalEditMenu);
    modals.push(modalEditName);
    modals.push(modalEditLastname);
    modals.push(modalEditEmail);
    modals.push(modalEditPicture);
    modals.push(modalEditPassword);


    modals.forEach((e, i) => {

        e.printModal();
        e.container.style = 'display: none';
        e.content.style = 'display: none';

        if (i == 0) {

            e.container.addEventListener('click', (ev) => {
                if (ev.target == e.container) {
                    e.container.style = 'display: none';
                    e.content.style = 'display: none';

                    formsContainersEl.forEach((containerEl) => {

                        let errorMessages = containerEl.querySelectorAll('.error-message');

                        errorMessages.forEach((errorEl) => {

                            errorEl.parentNode.removeChild(errorEl);

                        })

                    });

                    //clean fields
                    inputName.value = "";
                    inputLastname.value = "";
                    inputEmail.value = "";
                    inputActualPassword.value = "";
                    inputNewPassword.value = "";
                    inputRepetedPassword.value = "";
                }
            });


        }

        if (i > 0) {
            const btnPrev = document.getElementById('btn-prev-' + i);

            if (btnPrev != undefined) {
                btnPrev.addEventListener('click', () => {
                    e.container.style = 'display: none';
                    e.content.style = 'display: none';
                });
            }
        }

    });


    const btnNameOption = document.getElementById('btn-edit-name');
    const btnLastnameOption = document.getElementById('btn-edit-lastname');
    const btnEmailOption = document.getElementById('btn-edit-email');
    const btnPictureOption = document.getElementById('btn-edit-picture');
    const btnPasswordOption = document.getElementById('btn-edit-password');

    const formsContainersEl = document.querySelectorAll('.form-container');

    const nameContainerEl = document.getElementById('name-edit-container');
    const lastnameContainerEl = document.getElementById('lastname-edit-container');
    const emailContainerEl = document.getElementById('email-edit-container');
    const actualPasswordContainerEl = document.getElementById('password-actual-edit-container');
    const newPasswordContainerEl = document.getElementById('password-new-edit-container');
    const repetedPasswordContainerEl = document.getElementById('password-repeted-edit-container');

    const inputName = document.getElementById('input-edit-name');
    const inputLastname = document.getElementById('input-edit-lastname');
    const inputEmail = document.getElementById('input-edit-email');
    const inputActualPassword = document.getElementById('input-edit-password-actual');
    const inputNewPassword = document.getElementById('input-edit-password-new');
    const inputRepetedPassword = document.getElementById('input-edit-password-repeted');

    const btnSaveName = document.getElementById('btn-name-save');
    const btnSaveLastname = document.getElementById('btn-lastname-save');
    const btnSaveEmail = document.getElementById('btn-email-save');
    const btnSavePicture = document.getElementById('btn-picture-save');
    const btnSavePassword = document.getElementById('btn-password-save');


    let user_data = 
    {
        "id": document.querySelector('#user_data_id').value,
        "name": document.querySelector('#user_data_name').value,
        "email": document.querySelector('#user_data_email').value,
        "lastname": document.querySelector('#user_data_lastname').value,
    }

    btnEditUser.addEventListener('click', () => {
        modalEditMenu.container.style = 'background-color: rgba(255,255,255,0.3); display: flex';
        modalEditMenu.content.style = 'display: block';
    });

    btnNameOption.addEventListener('click', () => {
        modalEditName.container.style = 'display: flex';
        modalEditName.content.style = 'display: block';

        inputName.value = user_data.name;
    });

    btnLastnameOption.addEventListener('click', () => {
        modalEditLastname.container.style = 'display: flex';
        modalEditLastname.content.style = 'display: block';

        inputLastname.value = user_data.lastname;
    });

    btnEmailOption.addEventListener('click', () => {
        modalEditEmail.container.style = 'display: flex';
        modalEditEmail.content.style = 'display: block';

        inputEmail.value = user_data.email;
    });

    btnPictureOption.addEventListener('click', () => {
        modalEditPicture.container.style = 'display: flex';
        modalEditPicture.content.style = 'display: block';

        let imgEl = document.querySelector("#actual_image_user");

        imgEl.setAttribute("src", "controllers/ajax/imagepreview.controller.php?image_type=user&id_user=" + user_data.id);

        let uploadImage = document.querySelector("#input-user-image");

        uploadImage.addEventListener("change", (files) => {

            let reader = new FileReader;
            reader.readAsDataURL(files.srcElement.files[0]);
            
            reader.addEventListener('load', (e) => {
                let path = e.target.result;
                imgEl.setAttribute("src", path);
            });
        })
    });

    btnPasswordOption.addEventListener('click', () => {
        modalEditPassword.container.style = 'display: flex';
        modalEditPassword.content.style = 'display: block';
    });



    btnSaveName.addEventListener('click', (e) => {

        e.preventDefault();

        if (validateName(inputName.value)) {
            if (nameContainerEl.querySelector('.error-message') != undefined)
                nameContainerEl.removeChild(nameContainerEl.querySelector('.error-message'));
            
            let fdata = new FormData();
            fdata.append('user_id', user_data.id);
            fdata.append('field', 'nombre');
            fdata.append('value', inputName.value);
            sendAjaxRequest('controllers/ajax/useredit.controller.php', 'POST', fdata, (response) => {
                if(response.status == 200){
                    if(document.querySelector('#form-edit-name').getElementsByClassName('success-message')[0] == undefined){
                        printMessage('form-edit-name', response.message, 'success')
                        setFlickingMessage(document.querySelector('#form-edit-name').getElementsByClassName('success-message')[0]);
                        setTimeout(() => {
                            document.querySelector('#form-edit-name').removeChild(document.querySelector('#form-edit-name').getElementsByClassName('success-message')[0]);
                        }, 3500);
                    }

                    let name = document.querySelector('#user-name-profile').innerText.split(' ');
                    document.querySelector('#user-name-profile').innerText = inputName.value+' '+name[1];

                    user_data.name = inputName.value;

                }else {
                    if(document.querySelector('#form-edit-name').getElementsByClassName('error-message')[0] == undefined){
                        printMessage('form-edit-name', response.message, 'error');
                        
                        setFlickingMessage(document.querySelector('#form-edit-name').getElementsByClassName('error-message')[0]);
                        
                        setTimeout(() => {
                            document.querySelector('#form-edit-name').removeChild(document.querySelector('#form-edit-name').getElementsByClassName('error-message')[0]);
                        }, 3500);
                    }
                }
            });
            
        } else {
            let errorMessageEl = nameContainerEl.querySelector('.error-message');
            if (errorMessageEl == undefined) {
                printMessage('name-edit-container', 'Al menos 6 caracteres alfanumericos', 'error');
            } else {
                setFlickingMessage(errorMessageEl)
            }
        }

    });

    btnSaveLastname.addEventListener('click', (e) => {

        e.preventDefault();

        if (validateLastname(inputLastname.value)) {
            if (lastnameContainerEl.querySelector('.error-message') != undefined)
                lastnameContainerEl.removeChild(lastnameContainerEl.querySelector('.error-message'));
            
            let fdata = new FormData();
            fdata.append('user_id', user_data.id);
            fdata.append('field', 'apellido');
            fdata.append('value', inputLastname.value);
            sendAjaxRequest('controllers/ajax/useredit.controller.php', 'POST', fdata, (response) => {
                if(response.status == 200){
                    if(document.querySelector('#form-edit-lastname').getElementsByClassName('success-message')[0] == undefined){
                        printMessage('form-edit-lastname', response.message, 'success')
                        setFlickingMessage(document.querySelector('#form-edit-lastname').getElementsByClassName('success-message')[0]);
                        setTimeout(() => {
                            document.querySelector('#form-edit-lastname').removeChild(document.querySelector('#form-edit-lastname').getElementsByClassName('success-message')[0]);
                        }, 3500);
                    }

                    let name = document.querySelector('#user-name-profile').innerText.split(' ');
                    document.querySelector('#user-name-profile').innerText = name[0]+' '+inputLastname.value;

                    user_data.lastname = inputLastname.value;

                }else {
                    if(document.querySelector('#form-edit-lastname').getElementsByClassName('error-message')[0] == undefined){
                        printMessage('form-edit-lastname', response.message, 'error');
                        
                        setFlickingMessage(document.querySelector('#form-edit-lastname').getElementsByClassName('error-message')[0]);
                        
                        setTimeout(() => {
                            document.querySelector('#form-edit-lastname').removeChild(document.querySelector('#form-edit-lastname').getElementsByClassName('error-message')[0]);
                        }, 3500);
                    }
                }
            });
            
        } else {
            let errorMessageEl = lastnameContainerEl.querySelector('.error-message');
            if (errorMessageEl == undefined) {
                printMessage('lastname-edit-container', 'Al menos 6 caracteres alfanumericos', 'error');
            } else {
                setFlickingMessage(errorMessageEl)
            }
        }

    });

    btnSaveEmail.addEventListener('click', (e) => {

        e.preventDefault();

        if (validateEmail(inputEmail.value)) {
            if (emailContainerEl.querySelector('.error-message') != undefined)
                emailContainerEl.removeChild(emailContainerEl.querySelector('.error-message'));
            
            let fdata = new FormData();
            fdata.append('user_id', user_data.id);
            fdata.append('field', 'email');
            fdata.append('value', inputEmail.value);
            sendAjaxRequest('controllers/ajax/useredit.controller.php', 'POST', fdata, (response) => {
                if(response.status == 200){
                    if(document.querySelector('#form-edit-email').getElementsByClassName('success-message')[0] == undefined){
                        printMessage('form-edit-email', response.message, 'success')
                        setFlickingMessage(document.querySelector('#form-edit-email').getElementsByClassName('success-message')[0]);
                        setTimeout(() => {
                            document.querySelector('#form-edit-email').removeChild(document.querySelector('#form-edit-email').getElementsByClassName('success-message')[0]);
                        }, 3500);
                    }

                    user_data.emial = inputEmail.value;
                }else {
                    if(document.querySelector('#form-edit-email').getElementsByClassName('error-message')[0] == undefined){
                        printMessage('form-edit-email', response.message, 'error');
                        
                        setFlickingMessage(document.querySelector('#form-edit-email').getElementsByClassName('error-message')[0]);
                        
                        setTimeout(() => {
                            document.querySelector('#form-edit-email').removeChild(document.querySelector('#form-edit-email').getElementsByClassName('error-message')[0]);
                        }, 3500);
                    }
                }
            });
            
        } else {
            let errorMessageEl = emailContainerEl.querySelector('.error-message');
            if (errorMessageEl == undefined) {
                printMessage('email-edit-container', 'Ingrese un correo electronico valido', 'error');
            } else {
                setFlickingMessage(errorMessageEl)
            }
        }

    });

    btnSavePassword.addEventListener('click', (e) => {
        
        e.preventDefault();

        //validar formato password actual
        if (validatePassword(inputActualPassword.value)) {
            if (actualPasswordContainerEl.querySelector('.error-message') != undefined)
                actualPasswordContainerEl.removeChild(actualPasswordContainerEl.querySelector('.error-message'));
            
            //validar formato password nueva
            if(validatePassword(inputNewPassword.value)){
                
                if (newPasswordContainerEl.querySelector('.error-message') != undefined)
                    newPasswordContainerEl.removeChild(newPasswordContainerEl.querySelector('.error-message'));
                
                //validar igualdad password nueva - password repetida
                if(inputNewPassword.value === inputRepetedPassword.value){
                    if (repetedPasswordContainerEl.querySelector('.error-message') != undefined)
                        repetedPasswordContainerEl.removeChild(repetedPasswordContainerEl.querySelector('.error-message'));
                    
                    let fdata = new FormData();
                    fdata.append('user_id', user_data.id);
                    fdata.append('field', 'contrasenia');
                    fdata.append('value', inputNewPassword.value);
                    fdata.append('actual_password', inputActualPassword.value);
                    sendAjaxRequest('controllers/ajax/useredit.controller.php', 'POST', fdata, (response) => {
                        if(response.status == 200){
                            if(document.querySelector('#form-edit-password').getElementsByClassName('success-message')[0] == undefined){
                                printMessage('form-edit-password', response.message, 'success')
                                setFlickingMessage(document.querySelector('#form-edit-password').getElementsByClassName('success-message')[0]);
                                setTimeout(() => {
                                    document.querySelector('#form-edit-password').removeChild(document.querySelector('#form-edit-password').getElementsByClassName('success-message')[0]);
                                }, 3500);
                            }

                            inputActualPassword.value = "";
                            inputNewPassword.value = "";
                            inputRepetedPassword.value = "";
                        }else {
                            if(document.querySelector('#form-edit-password').getElementsByClassName('error-message')[0] == undefined){
                                printMessage('form-edit-password', response.message, 'error');
                                
                                setFlickingMessage(document.querySelector('#form-edit-password').getElementsByClassName('error-message')[0]);
                                
                                setTimeout(() => {
                                    document.querySelector('#form-edit-password').removeChild(document.querySelector('#form-edit-password').getElementsByClassName('error-message')[0]);
                                }, 3500);
                            }
                        }
                    });
                    
                } else {
                    let errorMessageEl = repetedPasswordContainerEl.querySelector('.error-message');
                    if (errorMessageEl == undefined) {
                        printMessage('password-repeted-edit-container', 'Las contraseñias no coinciden', 'error');
                    } else {
                        setFlickingMessage(errorMessageEl)
                    }
                    
                }
                
            }else {
                
                let errorMessageEl = newPasswordContainerEl.querySelector('.error-message');
                if (errorMessageEl == undefined) {
                    printMessage('password-new-edit-container', 'Al menos 6 caracteres alfanumericos', 'error');
                } else {
                    setFlickingMessage(errorMessageEl)
                }
                
            }
            
        } else {
            let errorMessageEl = actualPasswordContainerEl.querySelector('.error-message');
            if (errorMessageEl == undefined) {
                printMessage('password-actual-edit-container', 'Al menos 6 caracteres alfanumericos, un caracter en mayuscula y un simbolo', 'error');
            } else {
                setFlickingMessage(errorMessageEl)
            }
        }

    });

    btnSavePicture.addEventListener('click', (e) => {
        e.preventDefault();

        let upFile = document.querySelector("#input-user-image");

        if(upFile.files.length > 0 && upFile.value != ""){
            
            let fdata = new FormData();
            fdata.append('user_id', user_data.id);
            fdata.append('field', 'imagen_contenido');
            fdata.append('value', upFile.files[0]);
            sendAjaxRequest('controllers/ajax/useredit.controller.php', 'POST', fdata, (response) => {
                if(response.status == 200){
                    if(document.querySelector('#form-edit-picture').getElementsByClassName('success-message')[0] == undefined){
                        printMessage('form-edit-picture', response.message, 'success')
                        setFlickingMessage(document.querySelector('#form-edit-picture').getElementsByClassName('success-message')[0]);
                        setTimeout(() => {
                            document.querySelector('#form-edit-picture').removeChild(document.querySelector('#form-edit-picture').getElementsByClassName('success-message')[0]);
                        }, 3500);
                    }

                    document.querySelector("#user-image-profile").setAttribute("src", "controllers/ajax/imagepreview.controller.php?image_type=user&id_user=" + user_data.id + "&t=" + new Date().getTime());

                }else {
                    if(document.querySelector('#form-edit-picture').getElementsByClassName('error-message')[0] == undefined){
                        printMessage('form-edit-picture', response.message, 'error');
                        
                        setFlickingMessage(document.querySelector('#form-edit-picture').getElementsByClassName('error-message')[0]);
                        
                        setTimeout(() => {
                            document.querySelector('#form-edit-picture').removeChild(document.querySelector('#form-edit-picture').getElementsByClassName('error-message')[0]);
                        }, 3500);
                    }
                }

            });
        
        }

    });
}


