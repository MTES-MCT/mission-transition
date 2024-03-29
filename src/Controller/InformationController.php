<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController
{
    /**
     * @Route("/recherche-iframe", name="search_iframe")
     */
    public function searchIframe(): Response
    {
        return $this->render('search/iframe.html.twig');
    }

    /**
     * @Route("/poser-une-question", name="information_contact_advisor")
     */
    public function contactAdvisor(): Response
    {
        return $this->render('information/contact_advisor.html.twig');
    }

    /**
     * @Route("/comprendre", name="information_tee_knowledge")
     */
    public function learning(Request $request): Response
    {
        $section = $request->get('section');

        return $this->render('information/knowledge_main.html.twig', [
            'section' => $section
        ]);
    }

    /**
     * @Route("/comprendre/gestion-energetique", name="information_knowledge_energie")
     */
    public function energie(): Response
    {
        return $this->render('information/knowledge_subject/energie.html.twig');
    }

    /**
     * @Route("/comprendre/batiment-durable", name="information_knowledge_batiment")
     */
    public function batiment(): Response
    {
        return $this->render('information/knowledge_subject/batiment.html.twig');
    }

    /**
     * @Route("/comprendre/mobilite-durable", name="information_knowledge_mobilite")
     */
    public function mobilite(): Response
    {
        return $this->render('information/knowledge_subject/mobilite.html.twig');
    }

    /**
     * @Route("/comprendre/economie-circulaire", name="information_economie-circulaire")
     */
    public function economieCirculaire(): Response
    {
        return $this->render('information/knowledge_subject/economie_circulaire.html.twig');
    }

    /**
     * @Route("/comprendre/innovations-durables", name="information_innovations_durables")
     */
    public function innovation(): Response
    {
        return $this->render('information/knowledge_subject/innovations_durables.html.twig');
    }

    /**
     * @Route("/comprendre/achat-logistique", name="information_achat")
     */
    public function achat(): Response
    {
        return $this->render('information/knowledge_subject/achat_logistique.html.twig');
    }

    /**
     * @Route("/comprendre/ecosystemes", name="information_ecosystemes")
     *
     */
    public function ecosystemes(): Response
    {
        return $this->render('information/knowledge_subject/ecosystemes.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="information_mentions")
     *
     */
    public function mentions(): Response
    {
        return $this->render('information/mentions-legales.html.twig');
    }

    /**
     * @Route("/accessibilite", name="information_accessibility")
     *
     */
    public function accessibility(): Response
    {
        return $this->render('information/accessibility.html.twig');
    }

    /**
     * @Route("/donnee-personnelles-et-cookies", name="information_privacy")
     *
     */
    public function privacy(): Response
    {
        return $this->render('information/privacy.html.twig');
    }

    /**
     * @Route("/plan-du-site", name="information_sitemap")
     *
     */
    public function sitemap(): Response
    {
        return $this->render('information/sitemap.html.twig');
    }

    /**
     * @Route("/integration", name="information_integration")
     *
     */
    public function integration(): Response
    {
        return $this->render('information/integration.html.twig');
    }
}
