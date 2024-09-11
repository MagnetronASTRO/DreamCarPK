<?php

namespace App\Interfaces;

interface ReservationControllerInterface
{
    public function showUserReservations(): void;
    public function showReservation(int $id): void;
    public function addReservation(int $carId, string $fromDate, string $returnDate): array;

}