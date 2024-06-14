<div id="loginFormContainer" class="modal login-form">
    <form id="loginForm" class="modal-content animate" action="/login" method="post">
        <div class="container">
            <h2>Login</h2>
            <hr>
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>

        <div class="clearfix">
            <div>
                <button type="button" id="cancelLoginForm" class="cancelbtn">Cancel</button>
                <button type="submit" class="greenbtn">Login</button>
            </div>
            <div>
                <span>Don't have account yet?</span>
                <button type="button" id="showSingupForm" class="change-button">SIGN UP</button>
            </div>
        </div>
        </div>
    </form>
</div>