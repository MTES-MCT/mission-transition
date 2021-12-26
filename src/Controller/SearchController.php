<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Form\SearchFormType;
use App\Model\SearchFormModel;
use App\Repository\AidRepository;
use App\Repository\EnvironmentalTopicRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/recherche/resultats", name="search_results")
     */
    public function results(
        Request $request,
        AidRepository $aidRepository,
        RegionRepository $regionRepository,
        EnvironmentalTopicRepository $environmentalTopicRepository
    ): Response {
        $environmentalTopics = $environmentalTopicRepository->findBy([], ['name' => 'ASC']);
        $regions = $regionRepository->findBy([], ['name' => 'ASC']);
        $searchFormModel = new SearchFormModel();

        $form = $this->createForm(SearchFormType::class, $searchFormModel, [
            'environmentalTopics' => $environmentalTopics,
            'regions' => $regions,
            'method' => 'GET',
        ]);

        $form->handleRequest($request);
        $regionalLimit = 0;
        $nationalLimit = 0;
        if ($form->isSubmitted() && $form->isValid()) {
            $environmentalTopic = $searchFormModel->getEnvironmentalTopic();
            $aidType = SearchFormModel::getAidTypeFilters($searchFormModel->getAidType());
            $region = $searchFormModel->getRegion();
            $nationalLimit = $searchFormModel->getNationalLimit();
            $regionalLimit = $searchFormModel->getRegionalLimit();

            $regionalAids = $aidRepository->searchByCriteria(
                $aidType,
                $environmentalTopic,
                $region,
                Aid::PERIMETER_REGIONAL,
                $regionalLimit
            );

            $nationalAids = $aidRepository->searchByCriteria(
                $aidType,
                $environmentalTopic,
                $region,
                Aid::PERIMETER_NATIONAL,
                $nationalLimit
            );

            $counts = $aidRepository->countAids($aidType, $environmentalTopic, $region);
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
            'environmentalTopic' => $environmentalTopic ?? null,
            'nextRegionalLimit' => $regionalLimit + SearchFormModel::LIMIT_INCREASED_BY,
            'nextNationalLimit' => $nationalLimit + SearchFormModel::LIMIT_INCREASED_BY,
            'environmentalTopics' => $environmentalTopics,
        ]);
    }
}
