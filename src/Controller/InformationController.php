<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController
{
    /**
     * @Route("/qui-sommes-nous", name="information_who_are_we")
     */
    public function whoAreWe(): Response
    {
        return $this->render('information/who_are_we.html.twig');
    }

    /**
     * @Route("/poser-une-question", name="information_contact_advisor")
     */
    public function contactAdvisor(): Response
    {
        return $this->render('information/contact_advisor.html.twig');
    }
}
