document.addEventListener("DOMContentLoaded", () => {
    const addReservationForm = document.querySelector("#addReservationForm");
    if (addReservationForm !== null) {
        addReservationForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(addReservationForm);
            formData.append('action', 'addReservation');

            fetch('fetchAjax.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.replace('user_reservations');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }
});