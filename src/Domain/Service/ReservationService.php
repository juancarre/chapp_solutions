<?php


namespace App\Domain\Service;


use App\Api\Repository\ReservationRepository;
use App\Domain\Collections\ReservationCollection;
use App\Domain\Entity\Reservation;
use App\Domain\Entity\Room;
use App\Domain\Entity\User;
use App\Domain\Interfaces\ReservationRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class ReservationService
{
    /**
     * @var ReservationRepositoryInterface
     */
    private $reservationRepository;
    /**
     * @var ManagerRegistry
     */
    private $doctrine;


    /**
     * ReservationService constructor.
     * @param ReservationRepositoryInterface $reservationRepository
     * @param ManagerRegistry $doctrine
     */
    public function __construct(
        ReservationRepositoryInterface $reservationRepository,
        ManagerRegistry $doctrine
    )
    {
        $this->reservationRepository = $reservationRepository;
        $this->doctrine = $doctrine;
    }

    public function getActiveReservations(): ReservationCollection
    {
        $activeReservations =  $this->doctrine->getRepository(Reservation::class)->findAll();
    }

    public function executeReservation(User $user, $roomNumber)
    {
        $room = $this->doctrine->getRepository(Room::class)->find($roomNumber);

        $this->reservationRepository->executeReservation($user, $room);
    }
}