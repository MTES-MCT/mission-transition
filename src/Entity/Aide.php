<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Entity\Util\EntityTimestampable;
use App\Enum\Status;
use App\Repository\AideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AideRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']]
)]
#[ApiFilter(PropertyFilter::class)]
#[ApiFilter(SearchFilter::class, properties: [
    'zonesGeographiques' => 'exact',
    'typesAide' => 'exact',
    'sousThematiques' => 'exact',
    'sousThematiques.thematiques' => 'exact',
    'porteursAide' => 'exact',
    'etatsAvancementProjet' => 'exact',
    'description' => 'ipartial',
])]
class Aide
{
    use EntityTimestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("read")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Gedmo\Slug(fields: ['nomAideNormalise'])]
    #[Groups("read")]
    private $slug;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $nomAide;

    #[ORM\Column(type: 'text')]
    #[Groups("read")]
    private $nomAideNormalise;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups("read")]
    private $tauxSubventionMinimum;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups("read")]
    private $tauxSubventionMaximum;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $tauxSubventionCommentaire;

    #[ORM\Column(type: 'boolean')]
    #[Groups("read")]
    private $aapAmi;

    #[ORM\Column(type: 'text')]
    #[Groups("read")]
    private $description;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $exempleProjet;

    #[ORM\ManyToMany(targetEntity: SousThematique::class, mappedBy: 'aides')]
    #[Groups("read")]
    private $sousThematiques;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("read")]
    private $idSource;

    #[ORM\ManyToMany(targetEntity: TypeAide::class)]
    #[Groups("read")]
    private $typesAide;

    #[ORM\ManyToOne(targetEntity: RecurrenceAide::class)]
    #[Groups("read")]
    private $recurrenceAide;

    #[ORM\ManyToMany(targetEntity: EtatAvancementProjet::class)]
    #[Groups("read")]
    private $etatsAvancementProjet;

    #[ORM\ManyToMany(targetEntity: TypeDepense::class)]
    #[Groups("read")]
    private $typesDepense;

    #[ORM\ManyToMany(targetEntity: ZoneGeographique::class)]
    #[Groups("read")]
    #[ApiFilter(SearchFilter::class, properties: ['zoneGeographiques.id' => 'exact'])]
    private $zonesGeographiques;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups("read")]
    private $dateOuverture;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups("read")]
    private $datePreDepot;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups("read")]
    private $dateCloture;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $conditionsEligibilite;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $urlDescriptif;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $urlDemarche;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups("read")]
    private $contact;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups("read")]
    private $dateMiseAJour;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("read")]
    private $etat;

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups("read")]
    private $programmeAides = [];

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups("read")]
    private $porteursAide = [];

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups("read")]
    private $porteursSiren = [];

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups("read")]
    private $instructeursAide = [];

    #[ORM\Column(type: 'simple_array', nullable: true)]
    #[Groups("read")]
    private $beneficicairesAide = [];

    #[ORM\Column(type: 'array', nullable: true)]
    #[Groups("read")]
    private $thematiqueSource = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("read")]
    private $zoneGeographiqueSource;

    public function __construct()
    {
        $this->setEtat(Status::DRAFT->value);
        $this->sousThematiques = new ArrayCollection();
        $this->typesAide = new ArrayCollection();
        $this->etatsAvancementProjet = new ArrayCollection();
        $this->typesDepense = new ArrayCollection();
        $this->zonesGeographiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAide(): ?string
    {
        return $this->nomAide;
    }

    public function setNomAide(?string $nomAide): self
    {
        $this->nomAide = $nomAide;

        return $this;
    }

    public function getNomAideNormalise(): ?string
    {
        return $this->nomAideNormalise;
    }

    public function setNomAideNormalise(string $nomAideNormalise): self
    {
        $this->nomAideNormalise = $nomAideNormalise;

        return $this;
    }

    public function getTauxSubventionMinimum(): ?int
    {
        return $this->tauxSubventionMinimum;
    }

    public function setTauxSubventionMinimum(?int $tauxSubventionMinimum): self
    {
        $this->tauxSubventionMinimum = $tauxSubventionMinimum;

        return $this;
    }

    public function getTauxSubventionMaximum(): ?int
    {
        return $this->tauxSubventionMaximum;
    }

    public function setTauxSubventionMaximum(?int $tauxSubventionMaximum): self
    {
        $this->tauxSubventionMaximum = $tauxSubventionMaximum;

        return $this;
    }

    public function getTauxSubventionCommentaire(): ?string
    {
        return $this->tauxSubventionCommentaire;
    }

    public function setTauxSubventionCommentaire(?string $tauxSubventionCommentaire): self
    {
        $this->tauxSubventionCommentaire = $tauxSubventionCommentaire;

        return $this;
    }

    public function getAapAmi(): ?bool
    {
        return $this->aapAmi;
    }

    public function setAapAmi(bool $aapAmi): self
    {
        $this->aapAmi = $aapAmi;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExempleProjet(): ?string
    {
        return $this->exempleProjet;
    }

    public function setExempleProjet(?string $exempleProjet): self
    {
        $this->exempleProjet = $exempleProjet;

        return $this;
    }

    /**
     * @return Collection|SousThematique[]
     */
    public function getSousThematiques(): Collection
    {
        return $this->sousThematiques;
    }

    public function addSousThematique(SousThematique $sousThematique): self
    {
        if (!$this->sousThematiques->contains($sousThematique)) {
            $this->sousThematiques[] = $sousThematique;
            $sousThematique->addAide($this);
        }

        return $this;
    }

    public function removeSousThematique(SousThematique $sousThematique): self
    {
        if ($this->sousThematiques->removeElement($sousThematique)) {
            $sousThematique->removeAide($this);
        }

        return $this;
    }

    public function getIdSource(): ?string
    {
        return $this->idSource;
    }

    public function setIdSource(?string $idSource): self
    {
        $this->idSource = $idSource;

        return $this;
    }

    /**
     * @return Collection|TypeAide[]
     */
    public function getTypesAide(): Collection
    {
        return $this->typesAide;
    }

    public function addTypesAide(TypeAide $typesAide): self
    {
        if (!$this->typesAide->contains($typesAide)) {
            $this->typesAide[] = $typesAide;
        }

        return $this;
    }

    public function removeTypesAide(TypeAide $typesAide): self
    {
        $this->typesAide->removeElement($typesAide);

        return $this;
    }

    public function getRecurrenceAide(): ?RecurrenceAide
    {
        return $this->recurrenceAide;
    }

    public function setRecurrenceAide(?RecurrenceAide $recurrenceAide): self
    {
        $this->recurrenceAide = $recurrenceAide;

        return $this;
    }

    /**
     * @return Collection|EtatAvancementProjet[]
     */
    public function getEtatsAvancementProjet(): Collection
    {
        return $this->etatsAvancementProjet;
    }

    public function addEtatsAvancementProjet(EtatAvancementProjet $etatsAvancementProjet): self
    {
        if (!$this->etatsAvancementProjet->contains($etatsAvancementProjet)) {
            $this->etatsAvancementProjet[] = $etatsAvancementProjet;
        }

        return $this;
    }

    public function removeEtatsAvancementProjet(EtatAvancementProjet $etatsAvancementProjet): self
    {
        $this->etatsAvancementProjet->removeElement($etatsAvancementProjet);

        return $this;
    }

    /**
     * @return Collection|TypeDepense[]
     */
    public function getTypesDepense(): Collection
    {
        return $this->typesDepense;
    }

    public function addTypesDepense(TypeDepense $typesDepense): self
    {
        if (!$this->typesDepense->contains($typesDepense)) {
            $this->typesDepense[] = $typesDepense;
        }

        return $this;
    }

    public function removeTypesDepense(TypeDepense $typesDepense): self
    {
        $this->typesDepense->removeElement($typesDepense);

        return $this;
    }

    /**
     * @return Collection|ZoneGeographique[]
     */
    public function getZonesGeographiques(): Collection
    {
        return $this->zonesGeographiques;
    }


    public function addZonesGeographique(ZoneGeographique $zoneGeographique): self
    {
        if (!$this->zonesGeographiques->contains($zoneGeographique)) {
            $this->zonesGeographiques[] = $zoneGeographique;
        }

        return $this;
    }

    public function removeZonesGeographique(ZoneGeographique $zoneGeographique): self
    {
        $this->zonesGeographiques->removeElement($zoneGeographique);

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->dateOuverture;
    }

    public function setDateOuverture(?\DateTimeInterface $dateOuverture): self
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    public function getDatePreDepot(): ?\DateTimeInterface
    {
        return $this->datePreDepot;
    }

    public function setDatePreDepot(?\DateTimeInterface $datePreDepot): self
    {
        $this->datePreDepot = $datePreDepot;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(?\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getConditionsEligibilite(): ?string
    {
        return $this->conditionsEligibilite;
    }

    public function setConditionsEligibilite(?string $conditionsEligibilite): self
    {
        $this->conditionsEligibilite = $conditionsEligibilite;

        return $this;
    }

    public function getUrlDescriptif(): ?string
    {
        return $this->urlDescriptif;
    }

    public function setUrlDescriptif(?string $urlDescriptif): self
    {
        $this->urlDescriptif = $urlDescriptif;

        return $this;
    }

    public function getUrlDemarche(): ?string
    {
        return $this->urlDemarche;
    }

    public function setUrlDemarche(?string $urlDemarche): self
    {
        $this->urlDemarche = $urlDemarche;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDateMiseAJour(): ?\DateTimeInterface
    {
        return $this->dateMiseAJour;
    }

    public function setDateMiseAJour(?\DateTimeInterface $dateMiseAJour): self
    {
        $this->dateMiseAJour = $dateMiseAJour;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getProgrammeAides(): ?array
    {
        return $this->programmeAides;
    }

    public function setProgrammeAides(?array $programmeAides): self
    {
        $this->programmeAides = $programmeAides;

        return $this;
    }

    public function getPorteursAide(): ?array
    {
        return $this->porteursAide;
    }

    public function setPorteursAide(?array $porteursAide): self
    {
        $this->porteursAide = $porteursAide;

        return $this;
    }

    public function getPorteursSiren(): ?array
    {
        return $this->porteursSiren;
    }

    public function setPorteursSiren(?array $porteursSiren): self
    {
        $this->porteursSiren = $porteursSiren;

        return $this;
    }

    public function getInstructeursAide(): ?array
    {
        return $this->instructeursAide;
    }

    public function setInstructeursAide(?array $instructeursAide): self
    {
        $this->instructeursAide = $instructeursAide;

        return $this;
    }

    public function getBeneficicairesAide(): ?array
    {
        return $this->beneficicairesAide;
    }

    public function setBeneficicairesAide(?array $beneficicairesAide): self
    {
        $this->beneficicairesAide = $beneficicairesAide;

        return $this;
    }

    public function getThematiqueSource(): ?array
    {
        return $this->thematiqueSource;
    }

    public function setThematiqueSource(?array $thematiqueSource): self
    {
        $this->thematiqueSource = $thematiqueSource;

        return $this;
    }

    public function getZoneGeographiqueSource(): ?string
    {
        return $this->zoneGeographiqueSource;
    }

    public function setZoneGeographiqueSource(?string $zoneGeographiqueSource): self
    {
        $this->zoneGeographiqueSource = $zoneGeographiqueSource;

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
}
