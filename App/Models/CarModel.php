<?php

namespace App\Models;

class CarModel
{
    public function __construct(
        private int $id,
        private string $make,
        private string $model,
        private int $year,
        private bool $isAvailable,
        private ?string $carPhoto = "",
        private ?array $carPricing = [],
        private ?array $carSpecs = []
    ) {}

    // Getter and Setter for $id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getter and Setter for $make
    public function getMaker(): string
    {
        return $this->make;
    }

    public function setMaker(string $make): void
    {
        $this->make = $make;
    }

    // Getter and Setter for $model
    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    // Getter and Setter for $year
    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    // Getter and Setter for $isAvailable
    public function getIsAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): void
    {
        $this->isAvailable = $isAvailable;
    }

    // Getter and Setter for $carPhoto
    public function getCarPhoto(): ?string
    {
        return $this->carPhoto;
    }

    public function setCarPhoto(?string $carPhoto): void
    {
        $this->carPhoto = $carPhoto;
    }

    // Getter and Setter for $carPricing
    public function getCarPricing(): ?array
    {
        return $this->carPricing;
    }

    public function setCarPricing(?array $carPricing): void
    {
        $this->carPricing = $carPricing;
    }

    // Getter and Setter for $carSpecs
    public function getCarSpecs(): ?array
    {
        return $this->carSpecs;
    }

    public function setCarSpecs(?array $carSpecs): void
    {
        $this->carSpecs = $carSpecs;
    }
}
