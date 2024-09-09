<?php

namespace App\Interfaces;
use App\Models\ReservationModel;

interface ReservationRepositoryInterface
{
    public function getAllReservations(): array;

    public function getLastAddedReservation(): ReservationModel|false;

    public function getReservationById(int $reservationId): ReservationModel|false;

    public function getUserReservations(string $userId): array;


}