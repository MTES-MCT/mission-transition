<?php

namespace App\Entity;

use App\Entity\Util\EntityIdTrait;
use App\Entity\Util\EntitySoftDeletable;
use App\Entity\Util\EntityTimestampable;
use App\Repository\AidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Uid\Ulid;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Entity(repositoryClass=AidRepository::class)
 * @ORM\Table(name="aids")
 */
class Aid
{
    use EntityIdTrait;
    use EntityTimestampable;
    use EntitySoftDeletable;

    public const STATE_DRAFT = 'draft';
    public const STATE_PUBLISHED = 'published';

    public const TYPE_AAP = 'APP';
    public const TYPE_AID = 'Dispositif de financement';
    public const TYPE_COMPANY = 'Entreprise';
    public const TYPE_INVESTMENT_FUND = 'Fonds';
    public const TYPE_RECOVERY_PLAN = 'Plan de Relance';
    public const TYPE_FIRST_STEP = 'Premiers pas';
    public const TYPE_ENGINEER = 'Aide en ingénierie';

    public const PERIMETER_NATIONAL = 'NATIONAL';
    public const PERIMETER_REGIONAL = 'REGIONAL';
    /**
     * @ORM\Column(type="ulid", unique=true)
     */
    private Ulid $ulid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $sourceId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $perimeter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $goal;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $beneficiary;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $aidDetails;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $eligibility;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $conditions;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $fundingSourceUrl;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $applicationEndDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $applicationUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $state;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

    /**
     * @ORM\ManyToMany(targetEntity=EnvironmentalAction::class, inversedBy="aids")
     */
    private Collection $environmentalActions;

    /**
     * @ORM\ManyToOne(targetEntity=AidAdvisor::class)
     */
    private ?AidAdvisor $aidAdvisor;

    /**
     * @ORM\ManyToMany(targetEntity=EnvironmentalTopic::class, inversedBy="aids")
     */
    private Collection $environmentalTopics;

    /**
     * @ORM\ManyToOne(targetEntity=Funder::class)
     */
    private ?Funder $funder;

    /**
     * @ORM\ManyToMany(targetEntity=BusinessActivityArea::class)
     */
    private Collection $businessActivityAreas;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $fundingTypes = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\ManyToMany(targetEntity=Region::class, inversedBy="aids")
     */
    private Collection $regions;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $contactGuidelines;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $sourceUpdatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $subventionRateUpperBound;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $subventionRateLowerBound;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $loanAmount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $applicationStartDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $projectExamples;

    /**
     * @ORM\Column(type="boolean")
     */
    private $directAccess = false;

    public function __construct()
    {
        $this->ulid = new Ulid();
        $this->environmentalActions = new ArrayCollection();
        $this->environmentalTopics = new ArrayCollection();
        $this->businessActivityAreas = new ArrayCollection();
        $this->state = self::STATE_DRAFT;
        $this->regions = new ArrayCollection();
    }

    public function getUlid(): Ulid
    {
        return $this->ulid;
    }

    public function getSourceId(): ?string
    {
        return $this->sourceId;
    }

    public function setSourceId(?string $sourceId): self
    {
        $this->sourceId = $sourceId;

        return $this;
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

    public function getPerimeter(): ?string
    {
        return $this->perimeter;
    }

    public function setPerimeter(?string $perimeter): self
    {
        $this->perimeter = $perimeter;

        return $this;
    }

    public function isNational()
    {
        return strcmp($this->perimeter, 'NATIONAL');
    }

    public function getGoal(): ?string
    {
        return $this->goal;
    }

    public function setGoal(?string $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getBeneficiary(): ?string
    {
        return $this->beneficiary;
    }

    public function setBeneficiary(?string $beneficiary): self
    {
        $this->beneficiary = $beneficiary;

        return $this;
    }

    public function getAidDetails(): ?string
    {
        return $this->aidDetails;
    }

    public function setAidDetails(?string $aidDetails): self
    {
        $this->aidDetails = $aidDetails;

        return $this;
    }

    public function getEligibility(): ?string
    {
        return $this->eligibility;
    }

    public function setEligibility(?string $eligibility): self
    {
        $this->eligibility = $eligibility;

        return $this;
    }

    public function getConditions(): ?string
    {
        return $this->conditions;
    }

    public function setConditions(?string $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getFundingSourceUrl(): ?string
    {
        return $this->fundingSourceUrl;
    }

    public function setFundingSourceUrl(?string $fundingSourceUrl): self
    {
        $this->fundingSourceUrl = $fundingSourceUrl;

        return $this;
    }

    public function getApplicationEndDate(): ?\DateTimeInterface
    {
        return $this->applicationEndDate;
    }

    public function setApplicationEndDate(?\DateTimeInterface $applicationEndDate): self
    {
        $this->applicationEndDate = $applicationEndDate;

        return $this;
    }

    public function getApplicationUrl(): ?string
    {
        return $this->applicationUrl;
    }

    public function setApplicationUrl(?string $applicationUrl): self
    {
        $this->applicationUrl = $applicationUrl;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

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
        }

        return $this;
    }

    public function removeEnvironmentalAction(EnvironmentalAction $environmentalAction): self
    {
        $this->environmentalActions->removeElement($environmentalAction);

        return $this;
    }

    public function hasEnvironmentalAction(EnvironmentalAction $environmentalAction): bool
    {
        return $this->environmentalActions->contains($environmentalAction);
    }

    public function getAidAdvisor(): ?AidAdvisor
    {
        return $this->aidAdvisor;
    }

    public function setAidAdvisor(?AidAdvisor $aidAdvisor): self
    {
        $this->aidAdvisor = $aidAdvisor;

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

    public function getFunder(): ?Funder
    {
        return $this->funder;
    }

    public function setFunder(?Funder $funder): self
    {
        $this->funder = $funder;

        return $this;
    }

    /**
     * @return Collection|BusinessActivityArea[]
     */
    public function getBusinessActivityAreas(): Collection
    {
        return $this->businessActivityAreas;
    }

    public function addBusinessActivityArea(BusinessActivityArea $businessActivityArea): self
    {
        if (!$this->businessActivityAreas->contains($businessActivityArea)) {
            $this->businessActivityAreas[] = $businessActivityArea;
        }

        return $this;
    }

    public function removeBusinessActivityArea(BusinessActivityArea $businessActivityArea): self
    {
        $this->businessActivityAreas->removeElement($businessActivityArea);

        return $this;
    }

    public function getFundingTypes(): ?array
    {
        return $this->fundingTypes;
    }

    public function setFundingTypes(?array $fundingTypes): self
    {
        $this->fundingTypes = $fundingTypes;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        $this->regions->removeElement($region);

        return $this;
    }

    public function getContactGuidelines(): ?string
    {
        return $this->contactGuidelines;
    }

    public function setContactGuidelines(?string $contactGuidelines): self
    {
        $this->contactGuidelines = $contactGuidelines;

        return $this;
    }

    public function getSourceUpdatedAt(): ?\DateTimeInterface
    {
        return $this->sourceUpdatedAt;
    }

    public function setSourceUpdatedAt(?\DateTime $sourceUpdatedAt): self
    {
        $this->sourceUpdatedAt = $sourceUpdatedAt;

        return $this;
    }

    public function getSubventionRateUpperBound(): ?int
    {
        return $this->subventionRateUpperBound;
    }

    public function setSubventionRateUpperBound(?int $subventionRateUpperBound): self
    {
        $this->subventionRateUpperBound = $subventionRateUpperBound;

        return $this;
    }

    public function getSubventionRateLowerBound(): ?int
    {
        return $this->subventionRateLowerBound;
    }

    public function setSubventionRateLowerBound(?int $subventionRateLowerBound): self
    {
        $this->subventionRateLowerBound = $subventionRateLowerBound;

        return $this;
    }

    public function getLoanAmount(): ?int
    {
        return $this->loanAmount;
    }

    public function setLoanAmount(?int $loanAmount): self
    {
        $this->loanAmount = $loanAmount;

        return $this;
    }

    public function getApplicationStartDate(): ?\DateTimeInterface
    {
        return $this->applicationStartDate;
    }

    public function setApplicationStartDate(?\DateTimeInterface $applicationStartDate): self
    {
        $this->applicationStartDate = $applicationStartDate;

        return $this;
    }

    public function getProjectExamples(): ?string
    {
        return $this->projectExamples;
    }

    public function setProjectExamples(?string $projectExamples): self
    {
        $this->projectExamples = $projectExamples;

        return $this;
    }

    public function getDirectAccess(): ?bool
    {
        return $this->directAccess;
    }

    public function setDirectAccess(bool $directAccess): self
    {
        $this->directAccess = $directAccess;

        return $this;
    }
}
