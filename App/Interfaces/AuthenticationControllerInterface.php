<?php

namespace App\Interfaces;

interface AuthenticationControllerInterface
{
    public function isLoggedIn(): bool;

    public function getUserIdFromToken(): ?int;

    public function userHasRole(string $role): bool;

    public function logOut(): array;

    public function login(string $username, string $password): array;

    public function signUp(string $email, string $username, string $password): array;

}