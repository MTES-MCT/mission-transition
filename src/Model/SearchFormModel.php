<?php


namespace App\Model;

use App\Entity\EnvironmentalAction;

class SearchFormModel
{
    protected string $regionName;
    protected array $businessActivityAreas;
    protected array $environmentalActions;

    /**
     * @return string
     */
    public function getRegionName(): string
    {
        return $this->regionName;
    }

    /**
     * @param string $regionName
     * @return SearchFormModel
     */
    public function setRegionName(string $regionName): SearchFormModel
    {
        $this->regionName = $regionName;
        return $this;
    }

    public function getBusinessActivityAreasIds(): array
    {
        $businessActivityAreas = [];
        /** @var EnvironmentalAction $area */
        foreach ($this->businessActivityAreas as $area) {
            $businessActivityAreas[] = $area->getId();
        }

        return $businessActivityAreas;
    }

    /**
     * @return array
     */
    public function getBusinessActivityAreas(): array
    {
        return $this->businessActivityAreas;
    }

    /**
     * @param array $businessActivityAreas
     * @return SearchFormModel
     */
    public function setBusinessActivityAreas(array $businessActivityAreas): SearchFormModel
    {
        $this->businessActivityAreas = $businessActivityAreas;
        return $this;
    }

    public function getEnvironmentalActionIds(): array
    {
        $environmentalActionsIds = [];
        /** @var EnvironmentalAction $action */
        foreach ($this->environmentalActions as $action) {
            $environmentalActionsIds[] = $action->getId();
        }

        return $environmentalActionsIds;
    }

    /**
     * @return array
     */
    public function getEnvironmentalActions(): array
    {
        return $this->environmentalActions;
    }

    /**
     * @param array $environmentalActions
     * @return SearchFormModel
     */
    public function setEnvironmentalActions(array $environmentalActions): SearchFormModel
    {
        $this->environmentalActions = $environmentalActions;
        return $this;
    }
}
