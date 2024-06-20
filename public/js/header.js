document.addEventListener('DOMContentLoaded', function () {
    var navCheck = document.getElementById('nav-check');
    var navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            navCheck.checked = false;
            setTimeout(() => {
                // Force reflow to ensure the transition happens smoothly
                navCheck.offsetHeight;
            }, 10); // Slight delay to ensure the unchecking is processed
        });
    });
});
