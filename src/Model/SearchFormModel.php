<?php


namespace App\Model;

use App\Entity\EnvironmentalAction;

class SearchFormModel
{
    protected array $environmentalActions;

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
