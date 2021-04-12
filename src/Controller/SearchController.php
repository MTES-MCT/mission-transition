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
        $regionalLimit = 0;
        $nationalLimit = 0;
        if ($form->isSubmitted() && $form->isValid()){
            $environmentalAction = $searchFormModel->getEnvironmentalAction();
            $aidType = SearchFormModel::getAidTypeFilters($searchFormModel->getAidType());
            $region = $searchFormModel->getRegion();
            $nationalLimit = $searchFormModel->getNationalLimit();
            $regionalLimit = $searchFormModel->getRegionalLimit();

            $regionalAids = $aidRepository->searchByCriteria(
                $aidType,
                $environmentalAction,
                $region,
                Aid::PERIMETER_REGIONAL,
                $regionalLimit
            );

            $nationalAids = $aidRepository->searchByCriteria(
                $aidType,
                $environmentalAction,
                $region,
                Aid::PERIMETER_NATIONAL,
                $nationalLimit
            );

            $counts = $aidRepository->countAids($aidType, $environmentalAction, $region);
        }


        return $this->render('search/results.html.twig', [
            'form' => $form->createView(),
            'nationalAids' => $nationalAids ?? [],
            'regionalAids' => $regionalAids ?? [],
            'nbAids' => $counts['total'] ?? 0,
            'nbNationalAids' => $counts['national'] ?? 0,
            'nbRegionalAids' => $counts['regional'] ?? 0,
            'region' => $region ?? null,
            'isFundingType' => $searchFormModel->isFundingType(),
            'environmentalAction' => $environmentalAction ?? null,
            'nextRegionalLimit' => $regionalLimit + SearchFormModel::LIMIT_INCREASED_BY,
            'nextNationalLimit' => $nationalLimit + SearchFormModel::LIMIT_INCREASED_BY
        ]);
    }
}
