<?php

namespace App\Controllers;

use App\Interfaces\CarRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Models\UserModel;

class AdminController
{
    public function __construct(
        private UserRepositoryInterface        $userRepository,
        private CarRepositoryInterface         $carRepository,
        private ReservationRepositoryInterface $reservationRepository,
    )
    {
    }

    public function showUserManager()
    {
        $users = $this->userRepository->getAllUsers();

        require_once __DIR__ . '/../Views/UserManagerView.php';
    }

    public function showAddUserForm()
    {
        $roles = $this->userRepository->getRoles();

        require_once __DIR__ . '/../Views/AddUserFormView.php';
    }

    public function showEditUserForm()
    {
        $user = $this->userRepository->getUserById($_POST['showEditUserForm']);
        $roles = $this->userRepository->getRoles();
        require_once __DIR__ . '/../Views/EditUserFormView.php';
    }

    public function editUserData()
    {
        $response = ['success' => false, 'message' => 'User data edition failed'];
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

    public function addUser()
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

    public function changeUserActivity()
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

    public function showCarManager()
    {
//        $users = $this->carRepository->getAllCars();
//        require_once __DIR__ . '/../Views/CarManagerView.php';
    }

    public function showAddCarForm()
    {
        require_once __DIR__ . '/../Views/AddCarFormView.php';
    }

    public function showEditCarForm()
    {
        require_once __DIR__ . '/../Views/EditCarFormView.php';
    }

    public function editCarData()
    {
        //
    }

    public function addCar()
    {
        //
    }

    public function deleteCar()
    {
        //
    }


    public function showReservationManager()
    {
//        $users = $this->reservationRepository->getAllReservations();
//        require_once __DIR__ . '/../Views/CarManagerView.php';
    }
}