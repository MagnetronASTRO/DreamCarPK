<?php

namespace App\Controllers;

use App\Interfaces\CarRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;

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

    public function showEditUserForm()
    {
        require_once __DIR__ . '/../Views/EditUserFormView.php';
    }

    public function showAddUserForm()
    {
        require_once __DIR__ . '/../Views/AddUserFormView.php';
    }

    public function editUserData()
    {
        //
    }

    public function addUser()
    {
        //
    }

    public function deleteUser()
    {
        //
    }

    public function showCarManager()
    {
//        $users = $this->carRepository->getAllCars();
//        require_once __DIR__ . '/../Views/CarManagerView.php';
    }


    public function showEditCarForm()
    {
        require_once __DIR__ . '/../Views/EditCarFormView.php';
    }

    public function showAddCarForm()
    {
        require_once __DIR__ . '/../Views/AddCarFormView.php';
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