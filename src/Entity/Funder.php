<?php

namespace App\Entity;

use App\Entity\Util\EntityIdTrait;
use App\Repository\FunderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FunderRepository::class)
 * @ORM\Table(name="funders")
 */
class Funder
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $website;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
}
