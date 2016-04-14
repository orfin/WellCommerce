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
namespace WellCommerce\Bundle\CartBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CartBundle\Context\Front\CartContextInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorTraverserInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;

/**
 * Class CartSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -150],
            'cart.pre_create'        => ['onCartChangedEvent', 0],
            'cart.pre_update'        => ['onCartChangedEvent', 0],
            'cart.post_init'         => ['onCartInitEvent', 0],
            'order.post_create'      => ['onOrderPostCreateEvent', 0],
        ];
    }
    
    public function onKernelController()
    {
        $this->getCartManager()->initializeCart();
    }

    public function onOrderPostCreateEvent()
    {
        $this->getCartManager()->abandonCurrentCart();
    }

    public function onCartInitEvent(ResourceEvent $event)
    {
        $this->getCartVisitorTraverser()->traverse($event->getResource());
    }
    
    public function onCartChangedEvent(ResourceEvent $event)
    {
        $this->getCartVisitorTraverser()->traverse($event->getResource());
    }

    protected function getCartContext() : CartContextInterface
    {
        return $this->container->get('cart.context.front');
    }
    
    protected function getCartManager() : CartManagerInterface
    {
        return $this->container->get('cart.manager.front');
    }
    
    protected function getCartVisitorTraverser() : CartVisitorTraverserInterface
    {
        return $this->container->get('cart.visitor.traverser');
    }
}
