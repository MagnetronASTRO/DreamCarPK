<?php

namespace App\Repositories;

use App\Interfaces\DatabaseManagerInterface;
use App\Interfaces\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function __construct(private DatabaseManagerInterface $databaseManager) {}
}