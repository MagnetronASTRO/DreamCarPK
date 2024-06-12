document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.getElementById("signUpForm");

    registerForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(registerForm);
        const data = {
            username: formData.get("username"),
            password: formData.get("password"),
            email: formData.get("email")
        };

        try {
            const response = await fetch("/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            const messageDiv = document.getElementById("message");
            if (response.ok) {
                messageDiv.textContent = "Registration successful!";
            } else {
                messageDiv.textContent = "Registration failed: " + result.message;
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
});
