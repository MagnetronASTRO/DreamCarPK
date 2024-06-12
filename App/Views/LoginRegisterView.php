<!DOCTYPE html>
<html = >
<head>
    <title>Login/Register</title>
    <?php
        $signInScriptPath = 'js/sign_in.js';
        $signInScripVersion = filemtime($signInScriptPath);
        $signUpScriptPath = 'js/sign_up.js';
        $signUpScripVersion = filemtime($signUpScriptPath);
        $stylePath = 'css/login_register_styles.css';
        $styleVersion = filemtime($stylePath);
    ?>
    <script src="<?= $signInScriptPath ?>?v=<?= $signInScripVersion ?>"></script>
    <script src="<?= $signUpScriptPath ?>?v=<?= $signUpScripVersion ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= $stylePath ?>?v=<?= $styleVersion ?>">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">
    <div class="signup">
        <form method="post" action="" id="signUpForm">
            <label for="chk" aria-hidden="true">Sign up</label>
            <input type="hidden" name="type" value="signUp">
            <input type="text" name="txt" placeholder="User name" required="">
            <input type="email" name="email" placeholder="Email" required="">
            <input type="password" name="password" placeholder="Password" required="">
            <button>Sign up</button>
        </form>
    </div>

    <div class="login">
        <form method="post" action="" id="signInForm">
            <input type="hidden" name="type" value="signIn">
            <label for="chk" aria-hidden="true">Login</label>
            <input type="email" name="email" placeholder="Email" required="">
            <input type="password" name="password" placeholder="Password" required="">
            <button>Login</button>
        </form>
    </div>
</div>
</body>
</html>