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


//#### SIGNUP MODALS ####

const signupModal1 =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">
            <div class="padding-top"></div>
            <div class="web-logo-content">
                <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            <div class="signup-step fx fx-jc-fe">
                <span class="step">1/3</span>
            </div>
        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column" id="form-container">
                <div class="form-title">
                    <h2>Crea tu cuenta</h2>
                </div>
                
                <div class="row-input-content" id="username-signup-container">
                    <label for="user-username" class="label-input">Nombre de usuario</label>
                    <div class="input-content">
                        <input id="input-username" type="text" name="user-username">
                    </div>
                </div>
                <div class="row-input-content" id="email-signup-container">
                    <label for="user-email" class="label-input">Email</label>
                    <div class="input-content">
                        <input id="input-email" type="email" name="user-email">
                    </div>
                </div>
                <div class="row-input-content" id="password-signup-container">
                    <label for="user-password" class="label-input">Contraseña</label>
                    <div class="input-content">
                        <input id="input-password" type="password" name="password" name="user-password">
                    </div>
                </div>
                
                <div class="btn-content">
                    <button id="btn-next-0" type="submit" class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>`

const signupModal2 =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">
            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr" id="btn-prev-1">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span">Atras</span>
                </div>
            </div>
            <div class="web-logo-content">
               <img src="views/img/logo-white.png" class="logo-web" alt="">
            </div>
            <div class="signup-step fx fx-jc-fe">
                <span class="step">2/3</span>
            </div>
        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column" id="form-container">
                <div class="form-title">
                    <h2>Crea tu cuenta</h2>
                </div>
                
                <div class="row-input-content" id="name-signup-container">
                    <label for="user-name" class="label-input">Nombre</label>
                    <div class="input-content">
                        <input id="input-name" type="text" name="user-name">
                    </div>
                </div>
                <div class="row-input-content" id="lastname-signup-container">
                    <label for="user-lastname" class="label-input">Apellido</label>
                    <div class="input-content">
                        <input id="input-lastname" type="text" name="user-lastname">
                    </div>
                </div>
                <div class="btn-content">
                    <button type="submit" id="btn-next-1" class="btn btn-primary">Siguiente</button>
                </div>
            </div>
        </div>
    </div>`

const signupModal3 =
    `<div class="main-container fx fx-column">
        <div class="top-content fx fx-ai-ctr fx-jc-btw">
            <div class="padding-top">
                <div class="prev-step-container fx fx-ai-ctr" id="btn-prev-2">
                    <img src="views/img/previous-step.png" alt="previous step" class="prev-step-img">
                    <span class="prev-step-span">Atras</span>
                </div>
            </div>
            <div class="web-logo-content">
                <img src="views/img/logo-white.png" alt="logo web" class="logo-web">
            </div>
            <div class="signup-step fx fx-jc-fe">
                <span class="step">3/3</span>
            </div>
        </div>
        <div class="fx fx-jc-ctr">
            <div class="form-container fx fx-column" id="form-container">
                <div class="form-title">
                    <h2>Crea tu cuenta</h2>
                </div>
                <div class="up-img-container fx fx-column fx-ai-ctr fx-jc-btw">
                    <h3 class="form-title">Elige tu foto de perfil</h3>
                    <div class="upload-img-content">
                        <img src="views/img/upload-user-image.png" class="up-user-img" alt="upload user image">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </div>
                <div class="btn-content">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>`


let modals = []
modals.push(createModal(signupModal1));
modals.push(createModal(signupModal2));
modals.push(createModal(signupModal3));
modals[0].printModal();
modals[1].printModal();
modals[2].printModal();

const inputUsernameEl = document.getElementById('input-username');
const inputEmailEl = document.getElementById('input-email');
const inputPasswordEl = document.getElementById('input-password');
const inputNameEl = document.getElementById('input-name');
const inputLastnameEl = document.getElementById('input-lastname');

const formsContainersEl = document.querySelectorAll('#form-container');

const usernameContainerEl = document.getElementById('username-signup-container');
const emailContainerEl = document.getElementById('email-signup-container');
const passwordContainerEl = document.getElementById('password-signup-container');
const nameContainerEl = document.getElementById('name-signup-container');
const lastnameContainerEl = document.getElementById('lastname-signup-container');


let actualModal;

modals.forEach((m, i) => {
    m.container.style = 'display: none';
    m.content.style = 'display: none';
    m.content.style = 'height: 600px';
    
    if(i == 0) {
        
        
        m.container.addEventListener('click', (e) => {
            if(e.target == m.container) {
                m.container.style = 'display: none';
                m.content.style = 'display: none';
                
                
                formsContainersEl.forEach((containerEl) => {
                    
                    let errorMessages = containerEl.querySelectorAll('.error-message');

                    errorMessages.forEach((errorEl) => {

                        errorEl.parentNode.removeChild(errorEl);

                    })
                
                });
                
                
                inputUsernameEl.value = "";
                inputEmailEl.value = "";
                inputPasswordEl.value = "";
                inputNameEl.value = "";
                inputLastnameEl.value = "";
            }
        });
        
        
    }
    
    let nextBtn = document.getElementById('btn-next-' + i);
    
    if(nextBtn != undefined){
        nextBtn.addEventListener('click', () => {
            if(i == 0){
                if(validateFirstStep()){
                    showModal(i+1);
                }
            }else if(i == 1){
                if(validateSecondStep()){
                    showModal(i+1);
                }
            }
        });
    }
    
    let previousBtn = document.getElementById('btn-prev-' + i);
    
    if(previousBtn != undefined){
        previousBtn.addEventListener('click', () => {
            showModal(i-1);
        });
    }
    
})

function showModal(step) {
    
    if(actualModal != undefined) {
        actualModal.container.style = 'display: none';
        actualModal.content.style = 'display: none';
    }
    
    actualModal = modals[step];
    
    actualModal.container.style = 'display: flex';
    actualModal.content.style = 'display: block';
    
    
    actualModal.container.style = 'background-color: rgba(255,255,255,0.3)'
}

let btnSignup = document.getElementById('btn-signup');
btnSignup.addEventListener('click', () => {
    showModal(0)
});

    
function validateFirstStep(){
    
    if(validateUsername(inputUsernameEl.value)){
        if(usernameContainerEl.querySelector('.error-message') != undefined)
            usernameContainerEl.removeChild(usernameContainerEl.querySelector('.error-message'));
        
        if(validateEmail(inputEmailEl.value)) {
            if(emailContainerEl.querySelector('.error-message') != undefined)
                emailContainerEl.removeChild(emailContainerEl.querySelector('.error-message'));
            
            
            if(validatePassword(inputPasswordEl.value)){
                if(passwordContainerEl.querySelector('.error-message') != undefined)
                    passwordContainerEl.removeChild(passwordContainerEl.querySelector('.error-message'));
                
                return true;
            } else {
                
                let errorMessageEl = passwordContainerEl.querySelector('.error-message');
                if(errorMessageEl == undefined){
                    printMessage('password-signup-container', 'Al menos 6 caracteres alfanumericos, un caracter en mayuscula y un simbolo', 'error');    
                }else {
                    setFlickingMessage(errorMessageEl)
                }
                
            }
            
            
        } else {
            
            let errorMessageEl = emailContainerEl.querySelector('.error-message');
            if(errorMessageEl == undefined){
                printMessage('email-signup-container', 'Ingrese un correo electronico valido', 'error');    
            }else {
                setFlickingMessage(errorMessageEl)
            }
            
        }
        
        
    } else {
        let errorMessageEl = usernameContainerEl.querySelector('.error-message');
        if(errorMessageEl == undefined){
            printMessage('username-signup-container', 'Al menos 6 caracteres alfanumericos', 'error');    
        }else {
            setFlickingMessage(errorMessageEl)
        }
        
    }
        

    
    return false;
    
}

function validateSecondStep(){
    
    if(validateName(inputNameEl.value)){
        if(nameContainerEl.querySelector('.error-message') != undefined)
            nameContainerEl.removeChild(nameContainerEl.querySelector('.error-message'));
        
        if(validateLastname(inputLastnameEl.value)) {
            if(lastnameContainerEl.querySelector('.error-message') != undefined)
                lastnameContainerEl.removeChild(lastnameContainerEl.querySelector('.error-message'));
            
                return true;
        } else {
            let errorMessageEl = lastnameContainerEl.querySelector('.error-message');
            if(errorMessageEl == undefined){
                printMessage('lastname-signup-container', 'Al menos 6 caracteres alfanumericos', 'error');    
            }else {
                setFlickingMessage(errorMessageEl)
            }
        }
        
    } else {
        let errorMessageEl = nameContainerEl.querySelector('.error-message');
        if(errorMessageEl == undefined){
            printMessage('name-signup-container', 'Al menos 6 caracteres alfabeticos', 'error');    
        }else {
            setFlickingMessage(errorMessageEl)
        }
    }
    
    return false;
}
