<?php

namespace App\Controller\Admin;

use App\Entity\Alert;
use App\Entity\Arrival;
use App\Entity\ArrivalDetails;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Coupon;
use App\Entity\CouponType;
use App\Entity\Customer;
use App\Entity\Delivery;
use App\Entity\Faq;
use App\Entity\Like;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Payment;
use App\Entity\Photo;
use App\Entity\Product;
use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    /* 
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) 
    {

    } 
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl();
        return $this->redirect($url);
    }
    /*/

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }
    //*/

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E Shop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        
        // yield MenuItem::section('Authentification');
        // yield MenuItem::subMenu('Users', 'fas fa-users')->setSubItems([
        //     MenuItem::linkToCrud('Create user', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
        //     MenuItem::linkToCrud('Users', 'fas fa-eye', User::class)
        // ]);

        yield MenuItem::linkToCrud('Customers', 'fas fa-list', Customer::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-list', Product::class);
        yield MenuItem::linkToCrud('Photos', 'fas fa-list', Photo::class);
        yield MenuItem::linkToCrud('Likes', 'fas fa-list', Like::class);
        yield MenuItem::linkToCrud('Reviews', 'fas fa-list', Review::class);
        yield MenuItem::linkToCrud('Arrivals', 'fas fa-list', Arrival::class);
        yield MenuItem::linkToCrud('Arrivals details', 'fas fa-list', ArrivalDetails::class);

        //yield MenuItem::linkToCrud('Carriers', 'fas fa-list', Carrier::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-list', Order::class);
        yield MenuItem::linkToCrud('Order details', 'fas fa-list', OrderDetails::class);
        yield MenuItem::linkToCrud('Payments', 'fas fa-list', Payment::class);
        yield MenuItem::linkToCrud('Deliveries', 'fas fa-list', Delivery::class);

        yield MenuItem::linkToCrud('Coupons', 'fas fa-list', Coupon::class);
        yield MenuItem::linkToCrud('Coupon types', 'fas fa-list', CouponType::class);

        yield MenuItem::linkToCrud('Alerts', 'fas fa-list', Alert::class);
        yield MenuItem::linkToCrud('FAQs', 'fas fa-list', Faq::class);
    }
}
