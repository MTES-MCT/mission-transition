<?php

namespace App\Controller;

use App\Repository\AideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/recherche", name="search")
     */
    public function search(): Response
    {
        return $this->render('search/index.html.twig');
    }

    /**
     * @Route("/recherche/dispositif/{slug}", name="aid_view")
     */
    public function aid(string $slug, AideRepository $aidRepository): Response
    {
        $aid = $aidRepository->findOneBy([
            'slug' => $slug,
        ]);

        if (null === $aid) {
            return $this->redirectToRoute('search');
        }

        return $this->render('search/aid.html.twig', [
            'aid' => $aid,
        ]);
    }
}
