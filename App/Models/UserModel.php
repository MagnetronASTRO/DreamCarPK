<?php

namespace App\Models;

class UserModel
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $password,
        public string $email,
        public ?string $created_at
    ) {}
}