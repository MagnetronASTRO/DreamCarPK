document.addEventListener("DOMContentLoaded", () => {
    const logoutButton = document.querySelector("#logout");

    if (logoutButton !== null) {
        logoutButton.addEventListener("click", async (event) => {
            // event.preventDefault();

            let formData = new FormData();
            formData.append('action', 'logout');

            fetch('fetchAjax.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Logout successful');
                        window.location.reload();
                    } else {
                        alert('Logout failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }
});