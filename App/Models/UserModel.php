<?php

namespace App\Models;
class UserModel
{
    public function __construct(
        private int    $id,
        private string $username,
        private string $password,
        private string $email
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}