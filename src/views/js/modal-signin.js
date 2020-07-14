import {
    createModal,
    createCustomElement,
    validateUsername,
    validatePassword,
    setFlickingMessage,
    printMessage,
    sendAjaxRequest
} from './modal-helper.js';


const signinContent =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">

            <div class="padding-top"></div>

            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            <div class="padding-top">
            </div>

        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column" id="form-signin">

                <div class="form-title">
                    <h2>Iniciar sesion</h2>
                </div>
                <form method="POST" class="fx fx-column" id="form-signin">

                    <div class="row-input-content" id="username-signin-container">
                        <label for="user-username" class="label-input">Nombre de usuario</label>
                        <div class="input-content">
                            <input id="input-signin-username" type="text" name="user-username">
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
                </form>

            </div>

        </div>
    </div>`;


const btnSignin = document.getElementById('btn-signin');

btnSignin.addEventListener('click', (e) => {

    const signinModal = createModal(signinContent);
    signinModal.printModal();
    signinModal.container.style = 'background-color: rgba(255,255,255,0.3)'

    const btnEnter = signinModal.content.querySelector('#btn-enter');
    const inputUsername = signinModal.content.querySelector('#input-signin-username');
    const inputPassword = signinModal.content.querySelector('#input-signin-password');

    
    btnEnter.addEventListener('click', (e) => {

        e.preventDefault();

        let usernameValue = inputUsername.value;
        let passwordValue = inputPassword.value;
        
        const formSigninEl = signinModal.content.querySelector('#form-signin');
        const usernameContainerEl = signinModal.content.querySelector('#username-signin-container');
        const passwordContainerEl = signinModal.content.querySelector('#password-signin-container');

        if (validateUsername(usernameValue)) {
            if(usernameContainerEl.getElementsByClassName('error-message')[0] != undefined)
                usernameContainerEl.removeChild(usernameContainerEl.getElementsByClassName('error-message')[0])
            if(validatePassword(passwordValue)){
                if(passwordContainerEl.getElementsByClassName('error-message')[0] != undefined)
                    passwordContainerEl.removeChild(passwordContainerEl.getElementsByClassName('error-message')[0])


                let fdata = new FormData();
                fdata.append('username', usernameValue);
                fdata.append('password', passwordValue);
                sendAjaxRequest('controllers/ajax/signin.controller.php', 'POST', fdata, (response) => {
                    if(response.status == 200){
                        printMessage('form-signin', response.message, 'success')
                        setFlickingMessage(formSigninEl.getElementsByClassName('success-message')[0]);
                        setTimeout(() => {
                            window.location.href = 'http://localhost/phpseminario/src?page=home';
                        }, 3500);
                    }else {
                        if(formSigninEl.getElementsByClassName('error-message')[0] == undefined){
                            printMessage('form-signin', response.message, 'error');
                            
                            setFlickingMessage(formSigninEl.getElementsByClassName('error-message')[0]);
                            
                            setTimeout(() => {
                                formSigninEl.removeChild(formSigninEl.getElementsByClassName('error-message')[0]);
                            }, 3500);
                        }
                    }
                });


            }else {
                let errorMsgEl = passwordContainerEl.getElementsByClassName('error-message')[0];
                if (errorMsgEl == undefined) {
                    printMessage('password-signin-container', 'Ingrese una contraseña valida', 'error');
                } else {
                    setFlickingMessage(errorMsgEl);
                }
            }
        } else {
            let errorMsgEl = usernameContainerEl.getElementsByClassName('error-message')[0];
            if (errorMsgEl == undefined) {
                printMessage('username-signin-container', 'Ingrese un nombre de usuario valido', 'error');
            } else {
                setFlickingMessage(errorMsgEl);
            }

        }

    });

    signinModal.container.addEventListener('click', (e) => {
        if (e.target == signinModal.container) {
            signinModal.removeModal();
        }
    });
});



