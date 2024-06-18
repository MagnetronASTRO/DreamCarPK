<div id="signUpFormContainer" class="modal signup-form">
    <form id="signUpForm" class="modal-content animate">
        <div class="container">
            <h2>Sign Up</h2>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="password-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="password-repeat" required>

            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
            </label>

            <div class="clearfix">
                <div>
                    <button type="button" id="cancelSignUpForm" class="cancelbtn">Cancel</button>
                    <button type="submit" class="greenbtn">Sign Up</button>
                </div>
                <div>
                    <span>Already have account?</span>
                    <button type="button" id="showLoginForm" class="change-button">LOGIN</button>
                </div>
            </div>
        </div>
    </form>
</div>