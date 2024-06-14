<?php

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\UserModel;

class AuthenticationController
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
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

    public function login(): void
    {
        $response = ['success' => false, 'message' => 'Invalid credentials'];

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $user = $this->userRepository->getUserByEmail($email);


        if ($user && password_verify($password, $user->password)) {
//            $this->setLoginCookie($user->id);
            $response['success'] = true;
            $response['message'] = 'Login successful';
        }

//        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function signUp(): void
    {
        $response = ['success' => false, 'message' => 'Registration failed'];

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $newUser = new UserModel(
            id: 0,
            username: '',
            email: $email,
            role: 2,
            password: $hashedPassword,
        );

        if ($this->userRepository->createUser($newUser)) {
            $response['success'] = true;
            $response['message'] = 'Registration successful';
        }

        echo json_encode($response);
    }
}
