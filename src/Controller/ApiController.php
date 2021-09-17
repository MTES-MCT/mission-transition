<?php

namespace App\Controller;

use App\Repository\AidRepository;
use App\Repository\AidTypeRepository;
use App\Repository\EnvironmentalTopicCategoryRepository;
use App\Repository\EnvironmentalTopicRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api", name="api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/environmental-topics", name="api_environmentalTopics")
     */
    public function environmentalTopics(
        SerializerInterface $serializer,
        EnvironmentalTopicCategoryRepository $environmentalTopicCategoryRepository
    ): Response
    {
        $data = $serializer->serialize(
            $environmentalTopicCategoryRepository->findAllWithTopics(),
            'json',
            ['groups' => 'list']
        );

        return JsonResponse::fromJsonString($data);
    }

    /**
     * @Route("/aid-types", name="api_aidTypes")
     */
    public function aidTypes(
        SerializerInterface $serializer,
        AidTypeRepository $aidTypeRepository
    ): Response
    {
        $data = $serializer->serialize(
            $aidTypeRepository->findBy([], ['name' => 'ASC']),
            'json',
            ['groups' => 'list']
        );

        return JsonResponse::fromJsonString($data);
    }

    /**
     * @Route("/regions", name="api_regions")
     */
    public function regions(
        SerializerInterface $serializer,
        RegionRepository $regionRepository
    ): Response
    {
        $data = $serializer->serialize(
            $regionRepository->findBy([], ['name' => 'ASC']),
            'json',
            ['groups' => 'list']
        );

        return JsonResponse::fromJsonString($data);
    }

    /**
     * @Route("/aids", name="api_aids")
     */
    public function aids(
        Request $request,
        SerializerInterface $serializer,
        AidRepository $aidRepository
    ): Response
    {
        $query = $request->query;
        $environmentalTopics = (array) $query->get('topics', []);
        $aidTypes = (array)  $query->get('aidTypes', []);
        $regions = $query->get('regions', null);

        $data = $serializer->serialize(
            $aidRepository->searchByCriteria(
                $aidTypes,
                $environmentalTopics,
                $regions
            ),
            'json',
            ['groups' => 'list']
        );

        return JsonResponse::fromJsonString($data);
    }
}
