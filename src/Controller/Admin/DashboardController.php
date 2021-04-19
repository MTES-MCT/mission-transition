<?php

namespace App\Controller\Admin;

use App\Entity\Aid;
use App\Entity\AidAdvisor;
use App\Entity\EnvironmentalAction;
use App\Entity\EnvironmentalActionCategory;
use App\Entity\EnvironmentalTopic;
use App\Entity\Funder;
use App\Entity\Region;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Mission Transition');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Gestion des aides', 'fa fa-credit-card');
        yield MenuItem::linkToCrud('Dispositifs d\'aide', 'fa fa-user', Aid::class);
        yield MenuItem::linkToCrud('Thématiques', 'fa fa-user', EnvironmentalTopic::class);
        yield MenuItem::linkToCrud('Régions', 'fa fa-user', Region::class);
        yield MenuItem::linkToCrud('Objectifs Entreprises', 'fa fa-user', EnvironmentalAction::class);
        yield MenuItem::linkToCrud('Catégories d\'objectifs Entreprises', 'fa fa-user', EnvironmentalActionCategory::class);
        yield MenuItem::linkToCrud('Annuaire Financeurs', 'fa fa-user', Funder::class);
        yield MenuItem::linkToCrud('Annuaire Conseillers', 'fa fa-user', AidAdvisor::class);
    }
}
