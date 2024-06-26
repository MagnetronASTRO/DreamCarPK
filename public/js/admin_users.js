document.addEventListener("DOMContentLoaded", () => {
    const addUserForm = document.getElementById("addUserForm");
    // const editUserForm = document.querySelector("[name='editUserForm']");
    const changeUserActivity = document.querySelector(".changeUserActivity");

    fetchAjax(addUserForm, 'submit', 'addUser');
    // fetchAjax(editUserForm, 'submit', 'editUser');

    if (changeUserActivity !== null) {
        changeUserActivity.addEventListener("click", async (event) => {
            // event.preventDefault();
            console.log(this);
            let formData = new FormData();
            formData.append('action', 'changeUserActivity');
            // formData.append('changeUserActivity', this.);

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


    function fetchAjax(element, event = 'submit', actionName) {
        if (element !== null) {
            element.addEventListener(event, async (event) => {
                console.log('test 12342134');
                event.preventDefault();
        //
        //         const formData = new FormData(addUserForm);
        //         formData.append('action', actionName);
        //
        //         fetch('fetchAjax.php', {
        //             method: 'POST',
        //             body: formData
        //         })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.success) {
        //                     alert(data.message);
        //                     window.location.replace('admin=user_manager');
        //                 } else {
        //                     alert(data.message);
        //                 }
        //             })
        //             .catch(error => {
        //                 console.error('Error:', error);
        //             });
            });
        }
    }
});