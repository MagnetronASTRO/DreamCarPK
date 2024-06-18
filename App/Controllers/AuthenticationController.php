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

    public function login(string $email, string $password): array
    {
        $response = ['success' => false, 'message' => 'Invalid credentials'];

        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            $response['success'] = false;
            $response['message'] = "Invalid email address";
        }

        $user = $this->userRepository->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $this->setLoginCookie($user->id);
            $response['success'] = true;
            $response['message'] = 'Login successful';
        }

        return $response;
    }

    public function signUp(string $email, string $username, string $password): array
    {
        $response = ['success' => false, 'message' => 'Registration failed'];

        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            $response['success'] = false;
            $response['message'] = "Email is invalid";
            return $response;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($this->userRepository->getUserByEmail($email)) {
            $response['success'] = false;
            $response['message'] = "User with email: \"$email\" already exists";
            return $response;
        }

        $newUser = new UserModel(
            id: 0,
            username: $username,
            email: $email,
            role: 2,
            password: $hashedPassword,
        );

        if ($this->userRepository->createUser($newUser)) {
            $response['success'] = true;
            $response['message'] = 'Registration successful';
        }

        return $response;
    }
}
