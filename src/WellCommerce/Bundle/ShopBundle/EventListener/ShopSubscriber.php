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
            KernelEvents::REQUEST => ['onKernelRequest', 100]
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->get('shop.resolver.front')->resolve();
        $this->get('shop.resolver.admin')->resolve();
    }
}
