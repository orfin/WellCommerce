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
namespace WellCommerce\Bundle\OrderBundle\EventListener;

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;
use WellCommerce\Bundle\OrderBundle\Context\Front\CartContextInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\OrderBundle\Manager\Front\OrderManagerInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorTraverser;

/**
 * Class OrderSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -150],
            'order.post_init'        => ['onOrderPostInitEvent', 0],
            'order.post_create'      => ['onOrderPostCreateEvent', 0],
            'order.pre_update'       => ['onOrderPreUpdateEvent', 0],
        ];
    }

    public function onKernelController()
    {
        $this->getOrderManager()->initializeOrder();
    }

    public function onOrderPostInitEvent(ResourceEvent $event)
    {
        $order   = $event->getResource();
        $context = $this->getCartContext();
        if ($order instanceof OrderInterface && $context->hasCurrentCart()) {
            $this->getOrderConfirmationManager()->prepareOrderFromCart($order, $context->getCurrentCart());
        }
        
        Debug::dump($order);
        die();
    }
    
    public function onOrderPostCreateEvent()
    {
        $this->getCartManager()->abandonCurrentCart();
    }
    
    public function onOrderPostPreparedEvent(ResourceEvent $event)
    {
        $order = $event->getResource();
        if ($order instanceof OrderInterface) {
            $this->traverseOrder($order);
        }
    }
    
    public function onOrderPreUpdateEvent(ResourceEvent $event)
    {
        $order = $event->getResource();
        if ($order instanceof OrderInterface) {
            $this->traverseOrder($order);
        }
    }
    
    private function traverseOrder(OrderInterface $order)
    {
        $this->getOrderVisitorTraverser()->traverse($order);
    }
    
    private function getOrderVisitorTraverser() : OrderVisitorTraverser
    {
        return $this->container->get('order.visitor.traverser');
    }
    
    private function getOrderManager() : OrderManagerInterface
    {
        return $this->container->get('order.manager.front');
    }
}
