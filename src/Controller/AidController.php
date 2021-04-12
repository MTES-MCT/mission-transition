<?php

namespace App\Controller;

use App\Entity\Aid;
use App\Repository\AidRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AidController extends AbstractController
{
    /**
     * @Route("/dispositif/{slug}", name="aid_view")
     */
    public function index(string $slug, AidRepository $aidRepository): Response
    {
        $aid = $aidRepository->findOneBy([
            'slug' => $slug,
            'state' => Aid::STATE_PUBLISHED,
        ]);
        if (null === $aid) {
            return $this->redirectToRoute('search_results');
        }

        return $this->render('aid/index.html.twig', [
            'aid' => $aid,
        ]);
    }
}
