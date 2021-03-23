<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Form\SearchFormType;
use App\Model\SearchFormModel;
use App\Repository\AidRepository;
use App\Repository\EnvironmentalActionRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/recherche", name="search")
     */
    public function index(
        Request $request,
        EnvironmentalActionRepository $actionRepository,
        AidRepository $aidRepository,
        RegionRepository $regionRepository
    ): Response {
        $environmentalActions = $actionRepository->findAll();
        $regions = $regionRepository->findAll();
        $searchFormModel = new SearchFormModel();

        $form = $this->createForm(SearchFormType::class, $searchFormModel, [
            'environmentalActions' => $environmentalActions,
            'regions' => $regions,
            'method' => 'GET',
        ]);

        $form->handleRequest($request);

        $region = null;
        $environmentalAction = null;
        $nationalAids = [];
        $regionalAids = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $environmentalAction = $searchFormModel->getEnvironmentalAction();
            $aidType = $searchFormModel->getAidType();
            $region = $searchFormModel->getRegion();

            $aids = $aidRepository->searchByCriteria(
                SearchFormModel::getAidTypeFilters($aidType),
                $environmentalAction,
                [],
                $region
            );

            list($nationalAids, $regionalAids) = $this->sortAidsByPerimeter($aids);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'nationalAids' => $nationalAids,
            'regionalAids' => $regionalAids,
            'nbNationalAids' => count($nationalAids),
            'nbRegionalAids' => count($regionalAids),
            'region' => $region,
            'environmentalAction' => $environmentalAction,
        ]);
    }

    private function sortAidsByPerimeter(array $aids): array
    {
        $nationalAids = [];
        $regionalAids = [];
        /** @var Aid $aid */
        foreach ($aids as $aid) {
            if ($aid->isNational()) {
                $nationalAids[] = $aid;
            } else {
                $regionalAids[] = $aid;
            }
        }

        return [$nationalAids, $regionalAids];
    }
}
