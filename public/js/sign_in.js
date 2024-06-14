document.addEventListener("DOMContentLoaded", () => {
    const loginFormContainer = document.getElementById('loginFormContainer');
    const signUpFormContainer = document.getElementById('signUpFormContainer');

    const showSingupForm = document.getElementById('showSingupForm');
    const cancelLoginFormButton = document.getElementById('cancelLoginForm');

    cancelLoginFormButton.onclick = function (event) {
        loginFormContainer.style.display = "none";
    }

    showSingupForm.onclick = function (event) {
        loginFormContainer.style.display = "none";
        signUpFormContainer.style.display = "block";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onmousedown = function (event) {
        if (event.target === loginFormContainer) {
            loginFormContainer.style.display = "none";
        }
    }

    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(loginForm);
        const data = {
            password: formData.get("password"),
            email: formData.get("email")
        };

        fetch('/login', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Handle successful login (e.g., redirect to dashboard)
                alert('succesful');
                // window.location.href = '/';
            } else {
                // Handle login failure (e.g., display an error message)
                alert('Login failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});