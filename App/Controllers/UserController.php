<?php

namespace App\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\UserModel;
use App\Repositories\UserRepository;
use DateTime;

class UserController
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

//    public function showUser(int $id): void
//    {
////        $userData = $this->userRepository->getUserById($id);
////        $user = new UserModel(
////            $userData['id'],
////            $userData['username'],
////            $userData['password'],
////            $userData['email'],
////            new DateTime($userData['created_at'])
////        );
//
////        require 'App/Views/UsersListView.php';
//    }

    public function listUsers(): void
    {
        $users = $this->userRepository->getAllUsers();
//        $users = [...$usersResult];

//        $users = [
//            new UserModel(1, 'testowy_1', 'pass', 'emai@gmail.com', date("Y-m-d")),
//            new UserModel(1, 'testowy_2', 'pass1', 'emai@gmail.com', date("Y-m-d")),
//        ];

//        error_log(print_r($users));

//        foreach ($usersResult as $userData) {
//            $users
//        }
        require_once __DIR__ . '/../Views/UsersListView.php';
    }

    public function createUser(array $data): void
    {
        $this->userRepository->createUser($data);
        header('Location: /users');
    }

    public function updateUser(int $id, array $data): void
    {
        $this->userRepository->updateUser($id, $data);
        header('Location: /users/' . $id);
    }

    public function deleteUser(int $id): void
    {
        $this->userRepository->deleteUser($id);
        header('Location: /users');
    }
}
