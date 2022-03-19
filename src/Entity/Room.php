<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RoomType::class, inversedBy="id_type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $entry_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $exit_date;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?RoomType
    {
        return $this->type_id;
    }

    public function setType(?RoomType $type): self
    {
        $this->type_id = $type;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entry_date;
    }

    public function setEntryDate(?\DateTimeInterface $entry_date): self
    {
        $this->entry_date = $entry_date;

        return $this;
    }

    public function getExitDate(): ?\DateTimeInterface
    {
        return $this->exit_date;
    }

    public function setExitDate(?\DateTimeInterface $exit_date): self
    {
        $this->exit_date = $exit_date;

        return $this;
    }
}
