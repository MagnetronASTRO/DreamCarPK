<?php

namespace App\Controllers;

use App\Interfaces\AuthenticationControllerInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserModel;
use function PHPUnit\Framework\isNull;

class AuthenticationController implements AuthenticationControllerInterface
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

    private function setLoginSessionData(int $userId, int $userRole): void
    {
        $_SESSION['userId'] = $userId;
        $_SESSION['role'] = $userRole;
    }

    private function clearLoginCookie(): bool
    {
        return setcookie('user_token', '', time() - 3600, '/', '', true, true);
    }

    public function logOut(): array
    {
        $response = ['success' => false, 'message' => 'Invalid credentials'];

        if ($this->clearLoginCookie()) {
            session_unset();
            $response['success'] = true;
            $response['message'] = 'Logout successful';
        }

        return $response;
    }

    public function login(string $username, string $password): array
    {
        $response = ['success' => false, 'message' => 'Invalid credentials'];

        $sanitizedUsername = filter_var($username, FILTER_SANITIZE_EMAIL);

        $user = $this->userRepository->getUserByUserName($sanitizedUsername);

        if ($user && $user->getIsActive() === 0) {
            $response['success'] = false;
            $response['message'] = "User is blocked";
            return $response;
        }

        if ($user && password_verify($password, $user->getPassword())) {
            $this->setLoginCookie($user->getId());
            $this->setLoginSessionData($user->getId(), $user->getRole());
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

        if ($this->userRepository->getUserByUsername($username)) {
            $response['success'] = false;
            $response['message'] = "User with username: \"$username\" already exists!";
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
