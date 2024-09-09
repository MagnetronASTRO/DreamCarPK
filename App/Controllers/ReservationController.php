<?php

namespace App\Controllers;

use App\Interfaces\ReservationRepositoryInterface;

class ReservationController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {}

    public function showUserReservations(): void
    {
        $userId = $_SESSION['userId'];
        $reservations = $this->reservationRepository->getUserReservations(2);

        require_once __DIR__ . '/../Views/UserReservationsView.php';
    }

    public function showReservation($id): void
    {
        $reservation = $this->reservationRepository->getUserReservations($id);

        require_once __DIR__ . '/../Views/ReservationDetailsView.php';
    }

}