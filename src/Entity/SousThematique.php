<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SousThematiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: SousThematiqueRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']],
)]
class SousThematique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("read")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("read")]
    private $nom;

    #[ORM\ManyToMany(targetEntity: Aide::class, inversedBy: 'sousThematiques')]
    private $aides;

    #[ORM\ManyToMany(targetEntity: Thematique::class, mappedBy: 'sousThematique')]
    private $thematiques;

    public function __construct()
    {
        $this->aides = new ArrayCollection();
        $this->thematiques = new ArrayCollection();
    }

    public function __toString(): string
    {
        return implode(" |", $this->thematiques->toArray()) . ' => ' . $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Aide[]
     */
    public function getAides(): Collection
    {
        return $this->aides;
    }

    public function addAide(Aide $aide): self
    {
        if (!$this->aides->contains($aide)) {
            $this->aides[] = $aide;
        }

        return $this;
    }

    public function removeAide(Aide $aide): self
    {
        $this->aides->removeElement($aide);

        return $this;
    }

    /**
     * @return Collection|Thematique[]
     */
    public function getThematiques(): Collection
    {
        return $this->thematiques;
    }

    public function addThematique(Thematique $thematique): self
    {
        if (!$this->thematiques->contains($thematique)) {
            $this->thematiques[] = $thematique;
            $thematique->addSousThematique($this);
        }

        return $this;
    }

    public function removeThematique(Thematique $thematique): self
    {
        if ($this->thematiques->removeElement($thematique)) {
            $thematique->removeSousThematique($this);
        }

        return $this;
    }
}
