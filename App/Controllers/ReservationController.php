<?php

namespace App\Controllers;

use App\Interfaces\ReservationControllerInterface;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationController implements ReservationControllerInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {}

    public function showUserReservations(): void
    {
        $userId = $_SESSION['userId'];
        $reservations = $this->reservationRepository->getUserReservations($userId);

        require_once __DIR__ . '/../Views/UserReservationsView.php';
    }

    public function showReservation(int $id): void
    {
        $reservation = $this->reservationRepository->getUserReservations($id);

        require_once __DIR__ . '/../Views/ReservationDetailsView.php';
    }

    public function addReservation(int $carId, string $fromDate, string $returnDate): array
    {
        $response = ['success' => false, 'message' => 'Registration failed'];
        $userId = $_SESSION['userId'];

        if ($this->reservationRepository->addReservation($userId, $carId, $fromDate, $returnDate)) {
            $response['success'] = true;
            $response['message'] = 'Successfully reserved car.';
        }

        return $response;
    }

}