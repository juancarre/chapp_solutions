<?php


namespace App\Domain\Interfaces;


use App\Domain\Entity\Room;
use App\Domain\Entity\User;

interface ReservationRepositoryInterface
{
    public function getActiveReservations();

    public function executeReservation(User $user, Room $room);
}