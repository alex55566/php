document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const inputs = document.querySelectorAll('input');
    const loader = document.querySelector('.loader');

    const nameError = document.querySelector('.error-name');
    const emailError = document.querySelector('.error-email');

    let isValidName = true;
    let isValidEmail = true;

    let touchNameFiled = false;
    let touchEmailFiled = false;

    const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;

    form.addEventListener('submit', (e) => {
        inputs.forEach((input) => {
            if (input.classList.contains('name')) {
                checkName(input)
            }
            if (input.classList.contains('email')) {
                checkEmail(input)
            }
            input.addEventListener('input', () => {
                if (input.classList.contains('name') && touchNameFiled) {
                    checkName(input)
                }
                if (input.classList.contains('email') && touchEmailFiled) {
                    checkEmail(input)
                }
            })
        })
        if (!isValidEmail || !isValidName) {
            e.preventDefault();
            if (!isValidName) touchNameFiled = true;
            if (!isValidEmail) touchEmailFiled = true;
        }
        else {
            loader.classList.add('visible')
            form.classList.add('is-send')
        }
    })

    function checkName(el) {
        if (el.value.length < 2) {
            isValidName = false;
            nameError.classList.add('visible')
        } else {
            isValidName = true;
            nameError.classList.remove('visible')
        }
    }

    function checkEmail(el) {
        if (el.value.length !== 0 && !EMAIL_REGEXP.test(el.value)) {
            isValidEmail = false;
            emailError.classList.add('visible')
        } else {
            isValidEmail = true;
            emailError.classList.remove('visible')
        }
    }

    window.addEventListener("load", function(e) {
        loader.classList.remove('visible')
        form.classList.remove('is-send')
    })
})