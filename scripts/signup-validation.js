document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.form');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const checkboxInput = document.getElementById('checkbox');

    form.addEventListener('submit', function(event) {
        let valid = true;
        clearErrors();

        // Validate username
        if (usernameInput.value.trim() === '') {
            showError(usernameInput, 'Please enter a username.');
            valid = false;
        }

        // Validate email
        if (emailInput.value.trim() === '') {
            showError(emailInput, 'Email is required.');
            valid = false;
        } else if (!validateEmail(emailInput.value.trim())) {
            showError(emailInput, 'Please enter a valid email address.');
            valid = false;
        }

        // Validate password
        if (passwordInput.value.trim() === '') {
            showError(passwordInput, 'Password is required.');
            valid = false;
        } else if (passwordInput.value.length < 8) {
            showError(passwordInput, 'Password must be at least 8 characters.');
            valid = false;
        } else if (!/[A-Z]/.test(passwordInput.value)) {
            showError(passwordInput, 'Password must contain at least one uppercase letter.');
            valid = false;
        } else if (!/[0-9]/.test(passwordInput.value)) {
            showError(passwordInput, 'Password must contain at least one number.');
            valid = false;
        }

        // Validate confirm password
        if (confirmPasswordInput.value.trim() === '') {
            showError(confirmPasswordInput, 'Confirm password is required.');
            valid = false;
        } else if (confirmPasswordInput.value !== passwordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match.');
            valid = false;
        }

        // Validate terms and conditions checkbox
        if (!checkboxInput.checked) {
            showError(checkboxInput, 'You must agree to the terms and conditions.');
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    function showError(input, message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        input.parentNode.insertBefore(errorElement, input.nextSibling);
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(function(error) {
            error.remove();
        });
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
