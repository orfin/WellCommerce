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

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\ShopBundle\Repository\ShopRepositoryInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Event\DataSetRequestEvent;

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
            KernelEvents::REQUEST            => ['onKernelRequest', 100],
            'page.dataset.front.request'     => ['onShopAwareDataSetRequest', 0],
            'page.dataset.admin.request'     => ['onShopAwareDataSetRequest', 0],
            'category.dataset.front.request' => ['onShopAwareDataSetRequest', 0],
            'category.dataset.admin.request' => ['onShopAwareDataSetRequest', 0],
            'product.dataset.front.request'  => ['onShopAwareDataSetRequest', 0],
            'product.dataset.admin.request'  => ['onShopAwareDataSetRequest', 0],
            'producer.dataset.front.request' => ['onShopAwareDataSetRequest', 0],
            'producer.dataset.admin.request' => ['onShopAwareDataSetRequest', 0],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $firewallName         = $this->getSecurityHelper()->getFirewallNameForRequest($event->getRequest());
        $sessionAttributeName = $firewallName . '/shop/id';
        $currentShopId        = $this->getRequestHelper()->getSessionAttribute($sessionAttributeName);
        $host                 = $this->getRequestHelper()->getCurrentHost();
        $shop                 = $this->getShopRepository()->resolve((int)$currentShopId, $host);

        $this->getShopStorage()->setCurrentShop($shop);
        $this->getRequestHelper()->setSessionAttribute($sessionAttributeName, $shop->getId());
    }
    
    private function getShopRepository() : ShopRepositoryInterface
    {
        return $this->get('shop.repository');
    }

    public function onShopAwareDataSetRequest(DataSetRequestEvent $event)
    {
        $request = $event->getRequest();
        $request->addCondition(new Eq('shop', $this->getShopStorage()->getCurrentShopIdentifier()));
    }
}
