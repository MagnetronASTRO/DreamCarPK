<?php

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\UserModel;
use function PHPUnit\Framework\isNull;

class AuthenticationController
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function isLoggedIn(): bool
    {
    if (isset($_COOKIE['user_token'])) {
            $token = $_COOKIE['user_token'];
            return $this->userRepository->validateUserToken($token);
        }
        return false;
    }

    public function getUserIdFromToken(): ?int
    {
        if (isset($_COOKIE['user_token'])) {
            $token = $_COOKIE['user_token'];
            $userToken = $this->userRepository->getUserToken($token);
            return $userToken['user_id'] ?? NULL;
        }

        return NULL;
    }

    public function userHasRole(string $role): bool
    {
        $userId = $this->getUserIdFromToken();
        if ($userId !== null) {
            $roles = $this->userRepository->getUserRoles($userId);
            foreach ($roles as $userRole) {
                if ($userRole['role_name'] === $role) {
                    return true;
                }
            }
        }
        return false;
    }

    private function setLoginCookie(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $expireTime = time() + 60 * 60 * 24 * 4; // 4 days
        setcookie('user_token', $token, $expireTime, '/', '', true, true);

        $this->userRepository->setUserToken($userId, $token, $expireTime);
    }

    private function clearLoginCookie(): bool
    {
        return setcookie('user_token', '', time() - 3600, '/', '', true, true);
    }

    public function logOut(): array
    {
        $response = ['success' => false, 'message' => 'Invalid credentials'];

        if ($this->clearLoginCookie()) {
            $response['success'] = true;
            $response['message'] = 'Logout successful';
        }

        return $response;
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

        if ($user && $user->is_active === 0) {
            $response['success'] = false;
            $response['message'] = "User is blocked";
        }

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
