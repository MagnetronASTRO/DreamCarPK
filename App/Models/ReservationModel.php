<?php

namespace App\Models;

class ReservationModel
{
    public function __construct(
        private ?int $id,
        private ?int $userId,
        private ?CarModel $car,
        private ?string $fromDate,
        private ?string $returnDate,
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

    // Getter and Setter for $userId
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    // Getter and Setter for $car
    public function getCar(): ?CarModel
    {
        return $this->car;
    }

    public function setCar(?CarModel $car): void
    {
        $this->car = $car;
    }

    // Getter and Setter for $fromDate
    public function getFromDate(): ?string
    {
        return $this->fromDate;
    }

    public function setFromDate(?string $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    // Getter and Setter for $returnDate
    public function getReturnDate(): ?string
    {
        return $this->returnDate;
    }

    public function setReturnDate(?string $returnDate): void
    {
        $this->returnDate = $returnDate;
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
