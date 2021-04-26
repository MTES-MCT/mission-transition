<?php

namespace App\Entity;

use App\Repository\EnvironmentalActionCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EnvironmentalActionCategoryRepository::class)
 */
class EnvironmentalActionCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("environmentalAction:read")
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=EnvironmentalAction::class, mappedBy="category", cascade={"persist"})
     */
    private Collection $environmentalActions;

    public function __construct()
    {
        $this->environmentalActions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection|EnvironmentalAction[]
     */
    public function getEnvironmentalActions(): Collection
    {
        return $this->environmentalActions;
    }

    public function addEnvironmentalAction(EnvironmentalAction $environmentalAction): self
    {
        if (!$this->environmentalActions->contains($environmentalAction)) {
            $this->environmentalActions[] = $environmentalAction;
            $environmentalAction->setCategory($this);
        }

        return $this;
    }

    public function removeEnvironmentalAction(EnvironmentalAction $environmentalAction): self
    {
        if ($this->environmentalActions->removeElement($environmentalAction)) {
            // set the owning side to null (unless already changed)
            if ($environmentalAction->getCategory() === $this) {
                $environmentalAction->setCategory(null);
            }
        }

        return $this;
    }
}
