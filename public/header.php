<header>
    <div class="logo-container">
        <a href="/"><span class="logo">DreamCarPK</span></a>
    </div>
    <div class="nav">
        <input type="checkbox" id="nav-check">
        <div class="nav-header">
        </div>
        <div class="nav-btn">
            <label for="nav-check">
                <span></span>
                <span></span>
                <span></span>
            </label>
        </div>

        <div class="nav-links">
            <a href="/">HOME</a>
            <?php
            if ($authenticationController->isLoggedIn()) {
                echo "<a id='logout' style='width:auto;'>LOGOUT</a>";
            } else {
                echo "<a id='loginFormShow' onclick=\"document.getElementById('loginFormContainer').style.display='block'\" style='width:auto;'>LOGIN</a>";
            }

            if ($authenticationController->userHasRole('admin')) {
                echo "<a href='/admin=user_manager'>ADMIN</a>";
            } ?>
        </div>
    </div>
</header>