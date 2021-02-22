<?php

namespace App\Entity;

use App\Repository\FundraisingCardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\UuidV4;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Entity(repositoryClass=FundraisingCardRepository::class)
 * @ORM\Table(name="aids")
 */
class Aid
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private UuidV4 $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $deletedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $sourceId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $fundingType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $perimeter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $regionName;

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
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function __construct()
    {
        $this->environmentalActions = new ArrayCollection();
        $this->environmentalTopics = new ArrayCollection();
        $this->businessActivityAreas = new ArrayCollection();
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
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

    public function getFundingType(): ?string
    {
        return $this->fundingType;
    }

    public function setFundingType(string $fundingType): self
    {
        $this->fundingType = $fundingType;

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

    public function getRegionName(): ?string
    {
        return $this->regionName;
    }

    public function setRegionName(?string $regionName): self
    {
        $this->regionName = $regionName;

        return $this;
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
}
