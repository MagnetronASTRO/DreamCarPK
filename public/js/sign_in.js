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

    if (loginForm !== null) {
        loginForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const formData = new FormData(loginForm);
            formData.append('action', 'login');

            // for front-end validation
            const data = {
                password: formData.get("password"),
                email: formData.get("email")
            };

            fetch('fetchAjax.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Login failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }
});