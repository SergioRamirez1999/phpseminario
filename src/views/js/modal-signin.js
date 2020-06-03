import {
    createModal,
    createCustomElement,
    validateEmail,
    validatePassword,
    setFlickingMessage,
    printMessage
} from './modal-helper.js';

const signinContent =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top"></div>

            <div class="web-logo-content">
                <img src="./img/logo-white.png" class="logo-web" alt="">
            </div>
            <div class="padding-top">
            </div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column">

                <div class="form-title">
                    <h2>Iniciar sesion</h2>
                </div>
                

                <div class="row-input-content" id="email-signin-container">
                    <label for="user-email" class="label-input">Correo electronico</label>
                    <div class="input-content">
                        <input id="input-signin-email" type="email" name="user-email">
                    </div>
                </div>

                <div class="row-input-content" id="password-signin-container">
                    <label for="user-password" class="label-input">Contraseña</label>
                    <div class="input-content">

                        <input id="input-signin-password" type="password" name="user-password">
                    </div>
                </div>
                
                <div class="btn-content">
                    <button type="submit" id="btn-enter" class="btn btn-primary">Ingresar</button>
                </div>

            </div>

        </div>
    </div>`;





const signinModal = createModal(signinContent);
signinModal.printModal();

signinModal.container.style = 'display: none';
signinModal.content.style = 'display: none';


const btnSignin = document.getElementById('btn-signin');

btnSignin.addEventListener('click', () => {

    const btnEnter = document.getElementById('btn-enter');
    const inputEmail = document.getElementById('input-signin-email');
    const inputPassword = document.getElementById('input-signin-password');


    btnEnter.addEventListener('click', () => {
        let emailValue = inputEmail.value;
        let passwordValue = inputPassword.value;
        
        const emailContainerEl = document.getElementById('email-signin-container');
        const passwordContainerEl = document.getElementById('password-signin-container');
        if (validateEmail(emailValue)) {
            if(emailContainerEl.getElementsByClassName('error-message')[0] != undefined)
                emailContainerEl.removeChild(emailContainerEl.getElementsByClassName('error-message')[0])
            if(validatePassword(passwordValue)){
                if(passwordContainerEl.getElementsByClassName('error-message')[0] != undefined)
                    passwordContainerEl.removeChild(passwordContainerEl.getElementsByClassName('error-message')[0])
                //intentar sigin
            }else {
                let errorMsgEl = passwordContainerEl.getElementsByClassName('error-message')[0];
                if (errorMsgEl == undefined) {
                    printMessage('password-signin-container', 'Ingrese una contraseña valida', 'error');
                } else {
                    setFlickingMessage(errorMsgEl);
                }
            }
        } else {
            let errorMsgEl = emailContainerEl.getElementsByClassName('error-message')[0];
            if (errorMsgEl == undefined) {
                printMessage('email-signin-container', 'Ingrese un correo electronico valido', 'error');
            } else {
                setFlickingMessage(errorMsgEl);
            }

        }

    });

    signinModal.container.style = 'background-color: rgba(255,255,255,0.3); display: flex';
    signinModal.content.style = 'display: block';
    signinModal.container.addEventListener('click', (e) => {
        if (e.target == signinModal.container) {
            signinModal.container.style = 'display: none';
            signinModal.content.style = 'display: none';
            inputEmail.value = "";
            inputPassword.value = "";
            const emailContainerEl = document.getElementById('email-signin-container');
            let errorMsgEl = emailContainerEl.querySelector('.error-message');
            if (errorMsgEl != undefined)
                emailContainerEl.removeChild(errorMsgEl);
        }
    });
});



