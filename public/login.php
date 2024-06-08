<?php
// Poniżej przykładowy kod PHP do obsługi logowania
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        echo '<p style="color: red;">Invalid username or password</p>';
    }
}
//
//<!DOCTYPE html>
//<html lang="en">
//<head>
//    <meta charset="UTF-8">
//    <meta name="viewport" content="width=device-width, initial-scale=1.0">
//    <title>Login</title>
//    <link rel="stylesheet" href="../css/styles.css">
//</head>
//<body>
//<div class="login-container">
//    <h1>Login</h1>
//    <form action="login.php" method="post">
//        <div class="input-group">
//            <label for="username">Username</label>
//            <input type="text" id="username" name="username" required>
//        </div>
//        <div class="input-group">
//            <label for="password">Password</label>
//            <input type="password" id="password" name="password" required>
//        </div>
//        <button type="submit" class="login-button">Login</button>
//    </form>
//    <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
//</div>
//</body>
//</html>
//<!DOCTYPE html>
//<html lang="en">
//<head>
//    <meta charset="UTF-8">
//    <meta name="viewport" content="width=device-width, initial-scale=1.0">
//    <title>Login</title>
//    <link rel="stylesheet" href="../../css/login_page.css">
//</head>
//<body>
//<div class="login-container">
//    <h1>Login</h1>
//    <form action="login.php" method="post">
//        <div class="input-group">
//            <label for="username">Username</label>
//            <input type="text" id="username" name="username" required>
//        </div>
//        <div class="input-group">
//            <label for="password">Password</label>
//            <input type="password" id="password" name="password" required>
//        </div>
//        <button type="submit" class="login-button">Login</button>
//    </form>
//    <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
//</div>
//</body>
//</html>

