<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\ProductImage;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProductCrudController;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect(
            $adminUrlGenerator->setController(ProductCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CassandreV1');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
      yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
      yield MenuItem::linkToUrl(
            'Products',
            'fa-solid fa-utensils',
            $this->generateUrl('admin_product_index')
        );
        yield MenuItem::linkToUrl(
                'Categories',
                'fa-solid fa-list',
                $this->generateUrl('admin_category_index')
            );
            yield MenuItem::linkToUrl(
                 'site',
                    'fa-solid fa-globe',
                    $this->generateUrl('app_home')
            );
    }
}