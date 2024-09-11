<?php

namespace App\Models;

class UserModel
{
    public function __construct(
        private ?int $id,
        private ?string $username,
        private ?string $email,
        private ?int $role,
        private ?string $password = '',
        private ?string $createdAt = '',
        private ?int $isActive = 1,
    ) {}

    // Getter and Setter for $id
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    // Getter and Setter for $username
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    // Getter and Setter for $email
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    // Getter and Setter for $role
    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(?int $role): void
    {
        $this->role = $role;
    }

    // Getter and Setter for $password
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    // Getter and Setter for $createdAt
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    // Getter and Setter for $isActive
    public function getIsActive(): ?int
    {
        return $this->isActive;
    }

    public function setIsActive(?int $isActive): void
    {
        $this->isActive = $isActive;
    }
}
