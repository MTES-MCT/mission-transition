<?php

namespace App\Controller;

use App\Repository\AidTypeRepository;
use App\Repository\EnvironmentalTopicRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        EnvironmentalTopicRepository $environmentalTopicRepository
    ): Response
    {
        $data = $serializer->serialize(
            $environmentalTopicRepository->findBy([], ['name' => 'ASC']),
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
}
