import {
    createModal,
    validateName,
    validateLastname,
    validateUsername,
    validateEmail,
    validatePassword,
    setFlickingMessage,
    printMessage
} from './modal-helper.js';


const editMenuTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top"></div>

            <div class="web-logo-content">
                <img src="../img/logo-white.png" class="logo-web" alt="">
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
                    <img src="../img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-1">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="../img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar nombre</h2>
                </div>
                
                <div class="row-input-content" id="name-edit-container">
                    <label for="username-input" class="label-input">Nombre</label>
                    <div class="input-content">
                        <input type="text" name="username-input" id="input-edit-name">
                    </div>
                </div>

                
                <div class="btn-content">
                    <button type="submit" class="btn btn-primary" id="btn-name-save">Guardar</button>
                </div>

            </div>

        </div>
    </div>`

const editLastnameTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="../img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-2">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="../img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar apellido</h2>
                </div>
                
                <div class="row-input-content" id="lastname-edit-container">
                    <label for="lastname-input" class="label-input">Cambiar apellido</label>
                    <div class="input-content">
                        <input type="text" name="lastname-input" id="input-edit-lastname">
                    </div>
                </div>

                
                <div class="btn-content">
                    <button type="submit" class="btn btn-primary" id="btn-lastname-save">Guardar</button>
                </div>

            </div>

        </div>
    </div>`

const editEmailTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="../img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-3">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="../img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar correo electronico</h2>
                </div>
                
                <div class="row-input-content" id="email-edit-container">
                    <label for="email-input" class="label-input">Correo electronico</label>
                    <div class="input-content">
                        <input type="email" name="email-input" id="input-edit-email">
                    </div>
                </div>

                
                <div class="btn-content">
                    <button type="submit" class="btn btn-primary" id="btn-email-save">Guardar</button>
                </div>

            </div>

        </div>
    </div>`

const editPictureTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="../img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-4">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="../img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar foto de perfil</h2>
                </div>
                
                <div class="up-img-container fx fx-column fx-ai-ctr fx-jc-btw">
                    <h3 class="form-title">Elige tu foto de perfil</h3>

                    <div class="upload-img-content">
                        <img src="../img/upload-user-image.png" class="up-user-img" alt="upload user image">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary" id="btn-upload-picture">Subir</button>
                    </div>

                </div>

                
                <div class="btn-content">
                    <button type="submit" class="btn btn-primary" id="btn-picture-save">Guardar</button>
                </div>

            </div>

        </div>
    </div>`

const editPasswordTemplate =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr">
                    <img src="../img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span" id="btn-prev-5">Atras</span>
                </div>
            </div>

            <div class="web-logo-content">
                <img src="../img/logo-white.png" class="logo-web" alt="">
            </div>
            
            <div class="padding-top"></div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Cambiar contraseña</h2>
                </div>
                
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

            </div>

        </div>
    </div>`


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

                //clean fields
                inputName.value = "";
                inputLastname.value = "";
                inputEmail.value = "";
                inputActualPassword.value = "";
                inputNewPassword.value = "";
                inputRepetedPassword.value = "";
            });
        }
    }

});

const btnEditUser = document.getElementById('btn-edit-user');
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


btnEditUser.addEventListener('click', () => {
    modalEditMenu.container.style = 'background-color: rgba(255,255,255,0.3); display: flex';
    modalEditMenu.content.style = 'display: block';
});

btnNameOption.addEventListener('click', () => {
    modalEditName.container.style = 'display: flex';
    modalEditName.content.style = 'display: block';
});

btnLastnameOption.addEventListener('click', () => {
    modalEditLastname.container.style = 'display: flex';
    modalEditLastname.content.style = 'display: block';
});

btnEmailOption.addEventListener('click', () => {
    modalEditEmail.container.style = 'display: flex';
    modalEditEmail.content.style = 'display: block';
});

btnPictureOption.addEventListener('click', () => {
    modalEditPicture.container.style = 'display: flex';
    modalEditPicture.content.style = 'display: block';
});

btnPasswordOption.addEventListener('click', () => {
    modalEditPassword.container.style = 'display: flex';
    modalEditPassword.content.style = 'display: block';
});



btnSaveName.addEventListener('click', () => {

    if (validateName(inputName.value)) {
        if (nameContainerEl.querySelector('.error-message') != undefined)
            nameContainerEl.removeChild(nameContainerEl.querySelector('.error-message'));
        
        //guardar nombre
        
    } else {
        let errorMessageEl = nameContainerEl.querySelector('.error-message');
        if (errorMessageEl == undefined) {
            printMessage('name-edit-container', 'Al menos 6 caracteres alfanumericos', 'error');
        } else {
            setFlickingMessage(errorMessageEl)
        }
    }

});

btnSaveLastname.addEventListener('click', () => {

    if (validateLastname(inputLastname.value)) {
        if (lastnameContainerEl.querySelector('.error-message') != undefined)
            lastnameContainerEl.removeChild(lastnameContainerEl.querySelector('.error-message'));
        
        //guardar apellido
        
    } else {
        let errorMessageEl = lastnameContainerEl.querySelector('.error-message');
        if (errorMessageEl == undefined) {
            printMessage('lastname-edit-container', 'Al menos 6 caracteres alfanumericos', 'error');
        } else {
            setFlickingMessage(errorMessageEl)
        }
    }

});

btnSaveEmail.addEventListener('click', () => {

    if (validateEmail(inputEmail.value)) {
        if (emailContainerEl.querySelector('.error-message') != undefined)
            emailContainerEl.removeChild(emailContainerEl.querySelector('.error-message'));
        
        //guardar email
        
    } else {
        let errorMessageEl = emailContainerEl.querySelector('.error-message');
        if (errorMessageEl == undefined) {
            printMessage('email-edit-container', 'Ingrese un correo electronico valido', 'error');
        } else {
            setFlickingMessage(errorMessageEl)
        }
    }

});

btnSavePassword.addEventListener('click', () => {
    
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
                
                
                //hacer peticion para comprobar la contrasenia actual con la de la bbdd
                
                
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


