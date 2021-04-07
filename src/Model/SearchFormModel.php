<?php

namespace App\Model;

use App\Entity\Aid;
use App\Entity\EnvironmentalAction;
use App\Entity\Region;

class SearchFormModel
{
    public const TYPE_FUNDING = 'funding';
    public const TYPE_FIRST_STEPS = 'first-steps';
    public const LIMIT_INCREASED_BY = 3;

    protected string $aidType = self::TYPE_FUNDING;
    protected ?Region $region = null;
    protected EnvironmentalAction $environmentalAction;
    protected int $regionalLimit = 3;
    protected int $nationalLimit = 3;

    public static function getAidTypeFilters(string $aidType): array
    {
        if (0 === strcasecmp($aidType, self::TYPE_FIRST_STEPS)) {
            return [Aid::TYPE_FIRST_STEP];
        }

        return [Aid::TYPE_AAP, Aid::TYPE_AID, Aid::TYPE_INVESTMENT_FUND];
    }

    public function getAidType(): string
    {
        return $this->aidType;
    }

    public function setAidType(string $aidType): SearchFormModel
    {
        $this->aidType = $aidType;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @param Region|null $region
     */
    public function setRegion(Region $region): SearchFormModel
    {
        $this->region = $region;

        return $this;
    }

    public function isFundingType(): bool
    {
        return 0 === strcmp($this->aidType, SearchFormModel::TYPE_FUNDING);
    }

    public function getEnvironmentalAction(): EnvironmentalAction
    {
        return $this->environmentalAction;
    }

    public function setEnvironmentalAction(EnvironmentalAction $environmentalAction): SearchFormModel
    {
        $this->environmentalAction = $environmentalAction;

        return $this;
    }

    /**
     * @return int
     */
    public function getRegionalLimit(): int
    {
        return $this->regionalLimit;
    }

    /**
     * @param int $regionalLimit
     * @return SearchFormModel
     */
    public function setRegionalLimit(int $regionalLimit): SearchFormModel
    {
        $this->regionalLimit = $regionalLimit;
        return $this;
    }

    /**
     * @return int
     */
    public function getNationalLimit(): int
    {
        return $this->nationalLimit;
    }

    /**
     * @param int $nationalLimit
     * @return SearchFormModel
     */
    public function setNationalLimit(int $nationalLimit): SearchFormModel
    {
        $this->nationalLimit = $nationalLimit;
        return $this;
    }
}
