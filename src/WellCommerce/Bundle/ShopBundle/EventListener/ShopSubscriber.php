<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Bundle\ShopBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\ShopBundle\Entity\Shop;
use WellCommerce\Bundle\ShopBundle\Repository\ShopRepositoryInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;

/**
 * Class ShopSubscriber
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $firewallName         = $this->getSecurityHelper()->getFirewallNameForRequest($event->getRequest());
        $sessionAttributeName = $firewallName . '/shop/id';
        
        if (false === $this->getRequestHelper()->hasSessionAttribute($sessionAttributeName)) {
            $host = $this->getRequestHelper()->getCurrentHost();
            $shop = $this->getShopRepository()->resolve(0, $host);
            $this->getRequestHelper()->setSessionAttribute($sessionAttributeName, $shop->getId());
        } else {
            $currentShopId = $this->getRequestHelper()->getSessionAttribute($sessionAttributeName);
            $shop          = $this->getDoctrineHelper()->getEntityManager()->getReference(Shop::class, $currentShopId);
        }
        
        $this->getShopStorage()->setCurrentShop($shop);
    }
    
    private function getShopRepository(): ShopRepositoryInterface
    {
        return $this->get('shop.repository');
    }
}
