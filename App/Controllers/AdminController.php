<?php

namespace App\Controllers;

use App\Interfaces\AdminControllerInterface;
use App\Interfaces\CarRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Models\UserModel;

class AdminController implements AdminControllerInterface
{
    public function __construct(
        private UserRepositoryInterface        $userRepository,
        private CarRepositoryInterface         $carRepository,
        private ReservationRepositoryInterface $reservationRepository,
    )
    {
    }

    public function showUserManager(): void
    {
        $users = $this->userRepository->getAllUsers();

        require_once __DIR__ . '/../Views/UserManagerView.php';
    }

    public function showAddUserForm(): void
    {
        $roles = $this->userRepository->getRoles();

        require_once __DIR__ . '/../Views/AddUserFormView.php';
    }

    public function showEditUserForm(): void
    {
        $user = $this->userRepository->getUserById($_POST['showEditUserForm']);
        $roles = $this->userRepository->getRoles();
        require_once __DIR__ . '/../Views/EditUserFormView.php';
    }

    public function editUserData(int $userId, string $email, string $username, string $password, int $role): array
    {
        $response = ['success' => false, 'message' => 'User data edition failed'];

        $oldUserData = $this->userRepository->getUserById($userId);

        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            $response['success'] = false;
            $response['message'] = "Email is invalid!";
            return $response;
        }

        if (empty($password)) {
            $hashedPassword = $oldUserData->getPassword();
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        }

        $userByEmail = $this->userRepository->getUserByEmail($email);

        if ($userByEmail && $userByEmail->getEmail() != $oldUserData->getEmail()) {
            $response['success'] = false;
            $response['message'] = "User with email: \"$email\" already exists!";
            return $response;
        }

        $userByUsername = $this->userRepository->getUserByUsername($username);

        if ($userByUsername && $userByUsername->getUsername() != $oldUserData->getUsername()) {
            $response['success'] = false;
            $response['message'] = "User with username: \"$username\" already exists!";
            return $response;
        }

        // role must be admin: 1 or user: 2
        if (!in_array($role, [1, 2])) {
            $response['success'] = false;
            $response['message'] = "Non existing role selected!";
            return $response;
        }

        $updatedUserData = new UserModel(
            id: 0,
            username: $username,
            email: $email,
            role: $role,
            password: $hashedPassword,
        );

        if ($this->userRepository->updateUser($userId, $updatedUserData)) {
            $response['success'] = true;
            $response['message'] = 'User data changed successfully.';
        }

        return $response;
    }

    public function addUser(): array
    {
        $response = ['success' => false, 'message' => 'Registration failed'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $role = $_POST['role'];

        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
            $response['success'] = false;
            $response['message'] = "Email is invalid!";
            return $response;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($this->userRepository->getUserByEmail($email)) {
            $response['success'] = false;
            $response['message'] = "User with email: \"$email\" already exists!";
            return $response;
        }

        if ($this->userRepository->getUserByUsername($username)) {
            $response['success'] = false;
            $response['message'] = "User with username: \"$username\" already exists!";
            return $response;
        }

        // role must be admin: 1 or user: 2
        if (!in_array($role, [1, 2])) {
            $response['success'] = false;
            $response['message'] = "Non existing role selected!";
            return $response;
        }

        $newUser = new UserModel(
            id: 0,
            username: $username,
            email: $email,
            role: $role,
            password: $hashedPassword,
        );

        if ($this->userRepository->createUser($newUser)) {
            $response['success'] = true;
            $response['message'] = 'Successful user added successfully.';
        }

        return $response;
    }

    public function changeUserActivity(): array
    {
        $response['success'] = false;
        $response['message'] = 'Failed to change user status!.';
        $userId = $_POST['changeUserActivity'];

        if ($this->userRepository->changeUserActivity($userId)) {
            $response['success'] = true;
            $response['message'] = 'Successful user added successfully.';
        }

        return $response;
    }

    public function showCarManager(): void
    {
//        $users = $this->carRepository->getAllCars();
//        require_once __DIR__ . '/../Views/CarManagerView.php';
    }

    public function showAddCarForm(): void
    {
        require_once __DIR__ . '/../Views/AddCarFormView.php';
    }

    public function showEditCarForm(): void
    {
        require_once __DIR__ . '/../Views/EditCarFormView.php';
    }

    public function editCarData(): void
    {
        //
    }

    public function addCar(): void
    {
        //
    }

    public function deleteCar(): void
    {
        //
    }


    public function showReservationManager(): void
    {
//        $users = $this->reservationRepository->getAllReservations();
//        require_once __DIR__ . '/../Views/CarManagerView.php';
    }
}