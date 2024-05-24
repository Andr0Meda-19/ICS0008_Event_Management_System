document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('.form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    form.addEventListener('submit', function(event) {
        let valid = true;
        clearErrors();

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
