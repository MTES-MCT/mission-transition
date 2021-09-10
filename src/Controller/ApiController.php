<?php

namespace App\Controller;

use App\Repository\EnvironmentalTopicRepository;
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
}
