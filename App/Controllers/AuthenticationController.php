<?php

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\UserModel;

class AuthenticationController
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function showLoginRegisterForm()
    {
        require_once __DIR__ . '/../Views/LoginRegisterView.php';
    }

    private function setLoginCookie(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $expireTime = time() + 60 * 60 * 24 * 4; // 4 days
        setcookie('user_token', $token, $expireTime, '/', '', true, true);

        $this->userRepository->setUserToken($userId, $token, $expireTime);
    }

    private function clearLoginCookie(): void
    {
        setcookie('user_token', '', time() - 3600, '/', '', true, true);
    }

    public function logOut(): void
    {
        $this->clearLoginCookie();
        header('Location: /home');
        exit;
    }

    public function signIn(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
//
//        $user = $this->userRepository->getUserByEmail($email);
//
//        if ($user && password_verify($password, $user->password)) {
//            $this->setLoginCookie($user->id);
//            header('Location: /home');
//            exit();
//        } else {
//            echo 'invalid_credentials';
//        }
        echo 'test';
    }

    public function signUp(): void
    {
//        $email = $_POST['email'] ?? '';
//        $username = $_POST['username'] ?? '';
//        $password = $_POST['password'] ?? '';
//        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
//
//        $newUser = new UserModel(
//            id: 0,
//            username: $username,
//            email: $email,
//            role: 2,
//            password: $hashedPassword,
//        );
//
//        $this->userRepository->createUser($newUser);
//
//        header('Location: /login');
//        exit();
        echo 'test2';
    }
}
