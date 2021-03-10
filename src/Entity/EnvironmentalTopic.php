<?php

namespace App\Entity;

use App\Entity\Util\EntityIdTrait;
use App\Repository\ThematicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ThematicRepository::class)
 * @ORM\Table(name="environmental_topics")
 */
class EnvironmentalTopic
{
    use EntityIdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Aid::class, mappedBy="environmentalTopics")
     */
    private Collection $aids;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->aids = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
            $aid->addEnvironmentalTopic($this);
        }

        return $this;
    }

    public function removeAid(Aid $aid): self
    {
        if ($this->aids->removeElement($aid)) {
            $aid->removeEnvironmentalTopic($this);
        }

        return $this;
    }
}
