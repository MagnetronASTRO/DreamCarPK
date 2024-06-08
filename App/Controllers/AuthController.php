<?php

class AuthController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function showLoginForm() {
        require '../App/Views/login.php';
    }

    public function login($username, $password) {
        session_start();
        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /dashboard');
            exit;
        } else {
            echo 'Invalid username or password';
        }
    }

    public function showRegisterForm() {
        require '../App/Views/register.php';
    }

    public function register($username, $password, $email) {
        if ($this->userModel->create($username, $password, $email)) {
            header('Location: /login');
            exit;
        } else {
            echo 'Registration failed';
        }
    }
}