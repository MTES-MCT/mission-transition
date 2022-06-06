<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ThematiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ThematiqueRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']],
)]
class Thematique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('read')]
    private $nom;

    #[ORM\ManyToMany(targetEntity: SousThematique::class, inversedBy: 'thematiques')]
    #[Groups('read')]
    private $sousThematique;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    public function __construct()
    {
        $this->sousThematique = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNom();
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
     * @return Collection|SousThematique[]
     */
    public function getSousThematique(): Collection
    {
        return $this->sousThematique;
    }

    public function addSousThematique(SousThematique $sousThematique): self
    {
        if (!$this->sousThematique->contains($sousThematique)) {
            $this->sousThematique[] = $sousThematique;
        }

        return $this;
    }

    public function removeSousThematique(SousThematique $sousThematique): self
    {
        $this->sousThematique->removeElement($sousThematique);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
