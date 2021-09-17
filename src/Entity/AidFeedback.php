<?php

namespace App\Entity;

use App\Repository\AidFeedbackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AidFeedbackRepository::class)
 */
class AidFeedback
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $wasUseful;

    /**
     * @ORM\ManyToOne(targetEntity=Aid::class, inversedBy="feedbacks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWasUseful(): ?bool
    {
        return $this->wasUseful;
    }

    public function setWasUseful(bool $wasUseful): self
    {
        $this->wasUseful = $wasUseful;

        return $this;
    }

    public function getAid(): ?Aid
    {
        return $this->aid;
    }

    public function setAid(?Aid $aid): self
    {
        $this->aid = $aid;

        return $this;
    }
}
