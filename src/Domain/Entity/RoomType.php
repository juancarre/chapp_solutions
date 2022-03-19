<?php

namespace App\Entity;

use App\Repository\RoomTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomTypeRepository::class)
 */
class RoomType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Room::class, mappedBy="type")
     */
    private $id_type;

    public function __construct()
    {
        $this->id_type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getIdType(): Collection
    {
        return $this->id_type;
    }

    public function addIdType(Room $idType): self
    {
        if (!$this->id_type->contains($idType)) {
            $this->id_type[] = $idType;
            $idType->setType($this);
        }

        return $this;
    }

    public function removeIdType(Room $idType): self
    {
        if ($this->id_type->removeElement($idType)) {
            // set the owning side to null (unless already changed)
            if ($idType->getType() === $this) {
                $idType->setType(null);
            }
        }

        return $this;
    }
}
