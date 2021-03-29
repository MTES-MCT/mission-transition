<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Form\SearchFirstStepFormType;
use App\Form\SearchFormType;
use App\Form\SearchSecondStepFormType;
use App\Model\SearchFormModel;
use App\Repository\AidRepository;
use App\Repository\EnvironmentalActionRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchController extends AbstractController
{
    /**
     * @Route("/recherche", name="search_index")
     */
    public function index(
        Request $request,
        EnvironmentalActionRepository $actionRepository,
        RegionRepository $regionRepository,
        UrlGeneratorInterface $urlGenerator
    ) {
        $environmentalActions = $actionRepository->findAll();
        $searchFormModel = new SearchFormModel();

        $form = $this->createForm(SearchFirstStepFormType::class, $searchFormModel, [
            'environmentalActions' => $environmentalActions,
            'method' => 'GET',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regions = $regionRepository->findAll();

            $form = $this->createForm(SearchSecondStepFormType::class, $searchFormModel, [
                'regions' => $regions,
                'method' => 'GET',
                'action' => $urlGenerator->generate('search_results'),
            ]);

            return $this->render('search/index_step2.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('search/index_step1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recherche/resultats", name="search_results")
     */
    public function results(
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

            list($regionalAids, $nationalAids) = $this->sortAidsByPerimeter($aids);
        }

        return $this->render('search/results.html.twig', [
            'form' => $form->createView(),
            'nationalAids' => $nationalAids,
            'regionalAids' => $regionalAids,
            'nbNationalAids' => count($nationalAids),
            'nbRegionalAids' => count($regionalAids),
            'region' => $region,
            'isFundingType' => $searchFormModel->isFundingType(),
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
