// ### FUNCIONES CREACION MODALS ###

export const addAttributes = (element, attrObj) => {
    for (let attr in attrObj) {
        if (attrObj.hasOwnProperty(attr))
            element.setAttribute(attr, attrObj[attr])
    }
};

export const createCustomElement = (element, attributes, children) => {
    let customElement = document.createElement(element)
    if (children !== undefined) children.forEach(el => {
        if (el.nodeType) {
            if (el.nodeType === 1 || el.nodeType === 11)
                customElement.appendChild(el)
        } else {
            customElement.innerHTML += el
        }
    });

    addAttributes(customElement, attributes)
    return customElement
};


export function createModal(content) {
    let modalContent = createCustomElement('div', {
        id: 'modal-content',
        class: 'modal-content'
    }, [content]);

    // container principal
    let modalContainer = createCustomElement('div', {
        id: 'modal-container',
        class: 'modal-container'
    }, [modalContent]);


    return {
        content: modalContent,
        container: modalContainer,
        printModal: () => {
            document.body.appendChild(modalContainer)
        },
        removeModal: () => {
            modalContainer.remove();
        }
    }
}

export function validateName(name) {
    return REGEX_NAME.test(name);
}

export function validateLastname(lastname) {
    return REGEX_LASTNAME.test(lastname);
}

export function validateUsername(username) {
    return REGEX_USERNAME.test(username);
}

export function validateEmail(email) {
    return REGEX_EMAIL.test(email);
}

export  function validatePassword(password) {
    return REGEX_PASSWORD.test(password);
}

export function setFlickingMessage(messageEl) {
    messageEl.classList.add('flicker-message');

    setTimeout(() => {
        messageEl.classList.remove('flicker-message');
    }, 2000);
}

export function printMessage(nodeId, message, level) {
    const parentEl = document.getElementById(nodeId);

    const containerEl = document.createElement('div');
    containerEl.setAttribute('class', level+'-message');

    const messageEl = document.createElement('span');
    messageEl.innerHTML = message;

    containerEl.appendChild(messageEl);

    parentEl.appendChild(containerEl);

}

const REGEX_NAME = /^[a-zA-Z ]{6,}$/;
const REGEX_LASTNAME = /^[a-zA-Z ]{6,}$/;
const REGEX_USERNAME = /^[a-zA-Z0-9]{6,}$/;
const REGEX_EMAIL = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
const REGEX_PASSWORD = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{6,}$/;

