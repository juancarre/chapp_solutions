<?php

namespace App\Domain\Interfaces;

use App\Domain\Collections\RoomCollection;

interface RoomRepositoryInterface
{
    public function availablesRooms(\DateTime $entryDate, \DateTime $exitDate, int $guests): RoomCollection;
}