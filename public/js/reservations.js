
document.addEventListener("DOMContentLoaded", () => {
    const addReservationForm = document.querySelector("#addReservationForm");
    const fromDateInput = document.querySelector('#fromDate');
    const returnDateInput = document.querySelector('#returnDate');
    const totalPriceDisplay = document.querySelector('#totalpriceDisplay');
    const pricePerHourHolder = document.querySelector('#pricePerHour');

    returnDateInput.addEventListener('change', function() {
        updateTotalPrice();
    });

    fromDateInput.addEventListener('change', function() {
        updateTotalPrice();
    });

    if (addReservationForm !== null) {
        addReservationForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const fromDate = new Date(fromDateInput.value);
            const returnDate = new Date(returnDateInput.value);

            if (returnDate <= fromDate) {
                alert("Please ensure the return date is after the reservation date.");
                return;
            }

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

    function updateTotalPrice() {
        const fromDate = new Date(fromDateInput.value);
        const returnDate = new Date(returnDateInput.value);
        const pricePerHour = pricePerHourHolder.innerHTML.substring(1);

        // Validation: Ensure returnDate is after fromDate
        if (returnDate <= fromDate) {
            alert("Return date must be after the reservation date.");
            returnDateInput.value = ''; // Reset returnDate
            totalPriceDisplay.innerHTML = '0.00$'; // Reset total price
            return;
        }

        // Calculate total price based on number of days
        const timeDiff = returnDate - fromDate;
        const hoursDiff = Math.ceil(timeDiff / (1000 * 60 * 60)); // Convert milliseconds to days

        if (hoursDiff > 0) {
            const totalPrice = hoursDiff * pricePerHour;
            totalPriceDisplay.innerHTML = totalPrice.toFixed(2) + "$";
        } else {
            totalPriceDisplay.innerHTML = '0.00$';
        }
    }
});