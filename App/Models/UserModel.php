<?php

namespace App\Models;

class UserModel
{
    public function __construct(
        public ?int $id,
        public ?string $username,
        public ?string $email,
        public ?int $role,
        public ?string $password = '',
        public ?string $created_at = '',
        public ?int $is_active = 1,
    ) {}
}