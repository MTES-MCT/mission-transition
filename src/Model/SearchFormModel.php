<?php

namespace App\Model;

use App\Entity\EnvironmentalAction;
use App\Entity\Region;

class SearchFormModel
{
    protected const TYPE_FUNDING = 'funding';
    protected const TYPE_FIRST_STEPS = 'first-steps';

    protected string $aidType = self::TYPE_FUNDING;
    protected ?Region $region = null;
//    protected array $businessActivityAreas;
    protected EnvironmentalAction $environmentalAction;

    public static function getAidTypeFilters(string $aidType): array
    {
        if (0 === strcasecmp($aidType, self::TYPE_FIRST_STEPS)) {
            return ['Premiers Pas'];
        }

        return ['AAP', 'Aide', 'Fonds'];
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

//    public function getBusinessActivityAreasIds(): array
//    {
//        $businessActivityAreas = [];
//        /** @var EnvironmentalAction $area */
//        foreach ($this->businessActivityAreas as $area) {
//            $businessActivityAreas[] = $area->getId();
//        }
//
//        return $businessActivityAreas;
//    }
//
//    /**
//     * @return array
//     */
//    public function getBusinessActivityAreas(): array
//    {
//        return $this->businessActivityAreas;
//    }
//
//    /**
//     * @param array $businessActivityAreas
//     * @return SearchFormModel
//     */
//    public function setBusinessActivityAreas(array $businessActivityAreas): SearchFormModel
//    {
//        $this->businessActivityAreas = $businessActivityAreas;
//        return $this;
//    }

    public function getEnvironmentalAction(): EnvironmentalAction
    {
        return $this->environmentalAction;
    }

    public function setEnvironmentalAction(EnvironmentalAction $environmentalAction): SearchFormModel
    {
        $this->environmentalAction = $environmentalAction;

        return $this;
    }
}
