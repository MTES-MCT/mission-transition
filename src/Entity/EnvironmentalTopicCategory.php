<?php

namespace App\Entity;

use App\Repository\EnvironmentalTopicCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnvironmentalTopicCategoryRepository::class)
 */
class EnvironmentalTopicCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity=EnvironmentalTopic::class, inversedBy="environmentalTopicCategories")
     */
    private Collection $environmentalTopics;

    public function __construct()
    {
        $this->environmentalTopics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|EnvironmentalTopic[]
     */
    public function getEnvironmentalTopics(): Collection
    {
        return $this->environmentalTopics;
    }

    public function addEnvironmentalTopic(EnvironmentalTopic $environmentalTopic): self
    {
        if (!$this->environmentalTopics->contains($environmentalTopic)) {
            $this->environmentalTopics[] = $environmentalTopic;
        }

        return $this;
    }

    public function removeEnvironmentalTopic(EnvironmentalTopic $environmentalTopic): self
    {
        $this->environmentalTopics->removeElement($environmentalTopic);

        return $this;
    }
}
