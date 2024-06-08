<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Repositories\UserRepository;

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLoginForm()
    {
        require __DIR__ . '/../Views/LoginView.php';
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->userModel->getByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /dashboard');
            exit;
        } else {
            echo 'Invalid username or password';
        }
    }

    public function showRegisterForm()
    {
        require __DIR__ . '/../Views/register.php';
    }

    public function register()
    {
        $data = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => $_POST['email']
        ];

        if ($this->userModel->create($data)) {
            header('Location: /login');
            exit;
        } else {
            echo 'Registration failed';
        }
    }
}