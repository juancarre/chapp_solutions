<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locator;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="list", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\OneToOne(targetEntity=Room::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_room;

    /**
     * @ORM\Column(type="integer")
     */
    private $guests;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocator(): ?string
    {
        return $this->locator;
    }

    public function setLocator(string $locator): self
    {
        $this->locator = $locator;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdRoom(): ?Room
    {
        return $this->id_room;
    }

    public function setIdRoom(Room $id_room): self
    {
        $this->id_room = $id_room;

        return $this;
    }

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(int $guests): self
    {
        $this->guests = $guests;

        return $this;
    }
}
