<?php
namespace App\EventSubscriber;

use App\Entity\Alert;
use App\Entity\Arrival;
use App\Entity\Category;
use App\Entity\Coupon;
use App\Entity\CouponType;
use App\Entity\Customer;
use App\Entity\Faq;
use App\Entity\Like;
use App\Entity\Order;
use App\Entity\Photo;
use App\Entity\Product;
use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setCreatedAt'],
        ];
    }

    public function setCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();

        if (!($entityInstance instanceof Product) 
            && !($entityInstance instanceof Category)
            && !($entityInstance instanceof Photo)
            && !($entityInstance instanceof User)
            && !($entityInstance instanceof Customer)
            && !($entityInstance instanceof Like)
            && !($entityInstance instanceof Review)
            && !($entityInstance instanceof Arrival)
            && !($entityInstance instanceof Order)
            && !($entityInstance instanceof Coupon)
            && !($entityInstance instanceof CouponType)
            && !($entityInstance instanceof Faq)
            && !($entityInstance instanceof Alert)
            ) return;
        
        if(!$entityInstance->getCreatedAt()) $entityInstance->setCreatedAt(new \DateTimeImmutable);
    }
}
