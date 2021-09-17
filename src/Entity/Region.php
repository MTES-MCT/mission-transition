<?php

namespace App\Entity;

use App\Entity\Util\EntityIdTrait;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 */
class Region
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list"})
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity=Aid::class, mappedBy="regions")
     */
    private $aids;

    public function __construct()
    {
        $this->aids = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Aid[]
     */
    public function getAids(): Collection
    {
        return $this->aids;
    }

    public function addAid(Aid $aid): self
    {
        if (!$this->aids->contains($aid)) {
            $this->aids[] = $aid;
            $aid->addRegion($this);
        }

        return $this;
    }

    public function removeAid(Aid $aid): self
    {
        if ($this->aids->removeElement($aid)) {
            $aid->removeRegion($this);
        }

        return $this;
    }
}
