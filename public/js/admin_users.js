document.addEventListener("DOMContentLoaded", () => {
    const addUserForm = document.querySelector("#addUserForm");
    const editUserForm = document.querySelector("#editUserForm");
    const changeUserActivity = document.querySelectorAll(".changeUserActivity");

    fetchAjax(addUserForm, 'submit', 'addUser');
    fetchAjax(editUserForm, 'submit', 'editUserData');

    console.log(changeUserActivity);

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



    function fetchAjax(element, event = 'submit', actionName) {
        if (element !== null) {
            element.addEventListener(event, async (event) => {
                console.log('test 12342134');
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