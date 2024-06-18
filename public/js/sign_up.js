document.addEventListener("DOMContentLoaded", () => {
    const signUpFormContainer = document.getElementById('signUpFormContainer');
    const loginFormContainer = document.getElementById('loginFormContainer');

    const showLoginFormButton = document.getElementById('showLoginForm');
    const cancelSignUpForm = document.getElementById('cancelSignUpForm');

    cancelSignUpForm.onclick = function (event) {
        signUpFormContainer.style.display = "none";
    }

    // hide signUp form when changing to login form
    function showLoginForm() {
        signUpFormContainer.style.display = "none";
        loginFormContainer.style.display = "block";
    }

    showLoginFormButton.onclick = function (event) {
        showLoginForm();
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onmousedown = function (event) {
        if (event.target === signUpFormContainer) {
            signUpFormContainer.style.display = "none";
        }
    }

    const signUpForm = document.getElementById("signUpForm");

    signUpForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(signUpForm);
        formData.append('action', 'signUp');

        const data = {
            password: formData.get("password"),
            password_repeat: formData.get("password-repeat"),
            email: formData.get("email"),
            username: formData.get("username")
        };

        if (data.email === "" || data.username === "" || data.password === "") {
            alert('All fields are required');
            return;
        }

        if (data.password !== data.password_repeat) {
            alert('Passwords do not match');
            return;
        }

        fetch('fetchAjax.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Handle successful login (e.g., redirect to dashboard)
                    alert(data.message);
                    showLoginForm();
                } else {
                    // Handle login failure (e.g., display an error message)
                    alert('Login failed: ' + data.message);
                }
            }).catch(error => {
                console.error('Error:', error);
        });
    });
});
