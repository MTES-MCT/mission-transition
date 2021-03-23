<?php

namespace App\Controller\Admin;

use App\Entity\Aid;
use App\Entity\EnvironmentalTopic;
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
        return Dashboard::new()->setTitle('France Transition');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Gestion des aides', 'fa fa-credit-card');
        yield MenuItem::linkToCrud('Dispositifs d\'aide', 'fa fa-user', Aid::class);
        yield MenuItem::linkToCrud('Thématiques', 'fa fa-user', EnvironmentalTopic::class);
    }
}
