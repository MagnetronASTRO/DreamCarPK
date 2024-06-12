<?php

namespace App\Models;

class CarModel
{
    public function __construct(
        public int $id,
        public string $make,
        public string $model,
        public int $year,
        public bool $is_available,
        public ?string $carPhoto = "",
        public ?array $carPricing = [],
        public ?array $carSpecs = []
    ) {}
}
