<?php

namespace App\Models;

class ReservationModel
{
    public function __construct(
        public ?int $id,
        public ?int $userId,
        public ?CarModel $car,
        public ?string $fromDate,
        public ?string $returnDate,
        public ?int $isActive = 1,
    ) {}
}