<?php

namespace App\Interfaces;

interface AdminControllerInterface
{
    public function showUserManager(): void;
    public function showAddUserForm(): void;
    public function showEditUserForm(): void;
    public function editUserData(int $userId, string $email, string $username, string $password, int $role): array;
    public function addUser(): array;
    public function changeUserActivity(): array;
    public function showCarManager(): void;
    public function showAddCarForm(): void;
    public function showEditCarForm(): void;
    public function editCarData(): void;
    public function addCar(): void;
    public function deleteCar(): void;
    public function showReservationManager(): void;

}