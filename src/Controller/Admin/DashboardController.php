<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Aide;
use App\Entity\EtatAvancementProjet;
use App\Entity\RecurrenceAide;
use App\Entity\SousThematique;
use App\Entity\Thematique;
use App\Entity\TypeAide;
use App\Entity\TypeDepense;
use App\Entity\ZoneGeographique;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(AideCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mission Transition Ecologique - Backoffice')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Données du moteur');
        yield MenuItem::linkToCrud('Dispositifs', 'fas fa-list', Aide::class)->setController(AideCrudController::class);
        yield MenuItem::linkToCrud('Dispositifs à traiter', 'fas fa-list', Aide::class)->setController(AideACategoriserCrudController::class);
        yield MenuItem::linkToCrud('Types d\'aide', 'fas fa-list', TypeAide::class);
        yield MenuItem::linkToCrud('Etats d\'avancement de projet', 'fas fa-list', EtatAvancementProjet::class);
        yield MenuItem::linkToCrud('Recurrence des aides', 'fas fa-list', RecurrenceAide::class);
        yield MenuItem::linkToCrud('Thématiques', 'fas fa-list', Thematique::class);
        yield MenuItem::linkToCrud('Sous-thématiques', 'fas fa-list', SousThematique::class);
        yield MenuItem::linkToCrud('Types de dépense', 'fas fa-list', TypeDepense::class);
        yield MenuItem::linkToCrud('Zones géographiques', 'fas fa-list', ZoneGeographique::class);
        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Comptes admin', 'fas fa-list', Admin::class);
    }
}
