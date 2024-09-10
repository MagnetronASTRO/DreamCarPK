function toggleExpand(element) {
    // Get the next siblings of the clicked username, which are the hidden contents
    let sibling = element.nextElementSibling;
    let spanArrow = element.firstElementChild;

    if (spanArrow.innerHTML === "V") {
        spanArrow.innerHTML = "Ʌ";
    } else {
        spanArrow.innerHTML = "V";
    }

    // Toggle visibility of all hidden content in the same row
    while (sibling && sibling.classList.contains('hidden-content')) {
        sibling.classList.toggle('expanded'); // Add or remove the 'expanded' class
        sibling = sibling.nextElementSibling;
    }
}
document.addEventListener("DOMContentLoaded", () => {
    const addUserForm = document.querySelector("#addUserForm");
    const editUserForm = document.querySelector("#editUserForm");
    const changeUserActivity = document.querySelectorAll(".changeUserActivity");
    const goBackButton = document.querySelector("#goBack");

    fetchAjax(addUserForm, 'submit', 'addUser');
    fetchAjax(editUserForm, 'submit', 'editUserData');

    if (changeUserActivity !== null) {
        changeUserActivity.forEach(function (changeUserActivityButton) {
            changeUserActivityButton.addEventListener("click", async (e) => {
                const userId = changeUserActivityButton.value;
                let formData = new FormData();
                formData.append('action', 'changeUserActivity');
                formData.append('changeUserActivity', userId);

                fetch('fetchAjax.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (changeUserActivityButton.classList.contains('admin-green-btn')) {
                                changeUserActivityButton.classList.remove('admin-green-btn');
                                changeUserActivityButton.classList.add('admin-red-btn');
                                changeUserActivityButton.textContent = 'BLOCKED';
                            } else {
                                changeUserActivityButton.classList.remove('admin-red-btn');
                                changeUserActivityButton.classList.add('admin-green-btn');
                                changeUserActivityButton.textContent = 'ACTIVE';
                            }
                        } else {
                            // alert('Logout failed: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    }

    if (goBackButton !== null) {
       goBackButton.addEventListener("click", async (e) => {
           window.location.replace('admin=user_manager');
       });
    }

    function fetchAjax(element, event = 'submit', actionName) {
        if (element !== null) {
            element.addEventListener(event, async (event) => {
                event.preventDefault();

                const formData = new FormData(element);
                formData.append('action', actionName);

                fetch('fetchAjax.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.replace('admin=user_manager');
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        }
    }
});