<?php

namespace App\Domain\Service;

use App\Api\Repository\RoomRepository;
use App\Domain\Collections\RoomCollection;
use App\Domain\Entity\Room;
use App\Domain\Interfaces\RoomRepositoryInterface;

class RoomService
{
    /**
     * @var RoomRepositoryInterface
     */
    private $roomRepository;

    /**
     * RoomService constructor.
     * @param RoomRepositoryInterface $roomRepository
     */
    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function availablesRooms(\DateTime $entryDate, \DateTime $exitDate, int $guests): RoomCollection {

        $roomCollection = new RoomCollection();
        $roomsAvailable = $this->roomRepository->findAll();

        foreach ($roomsAvailable as $room) {
            $roomCollection->add($room);
        }

        return $roomCollection;
    }
}