<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Entity\EnvironmentalAction;
use App\Form\SearchFormType;
use App\Model\SearchFormModel;
use App\Repository\AidRepository;
use App\Repository\EnvironmentalActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(
        Request $request,
        EnvironmentalActionRepository $actionRepository,
        AidRepository $aidRepository
    ): Response
    {
        $environmentalActions = $actionRepository->findAll();
        $searchFormModel = new SearchFormModel();

        $form = $this->createForm(SearchFormType::class, $searchFormModel, [
            'environmentalActions' => $environmentalActions,
            'method' => 'GET'
        ]);

        $form->handleRequest($request);

        $aidsByActions = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $environmentalActionsIds = $searchFormModel->getEnvironmentalActionIds();
            $aids = $aidRepository->searchByCriteria($environmentalActionsIds);
            $aidsByActions = $this->orderAidsByActions($searchFormModel->getEnvironmentalActions(), $aids);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'aidsByActions' => $aidsByActions
        ]);
    }

    private function orderAidsByActions(array $actions, array $aids): array
    {
        $aidsByActions = [];
        /** @var EnvironmentalAction $action */
        foreach($actions as $action) {
            /** @var Aid $aid */
            foreach($aids as $aid) {
                if ($aid->hasEnvironmentalAction($action)) {
                    $aidsByActions[$action->getName()][] = $aid;
                }
            }
        }

        return $aidsByActions;
    }
}
