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
use WellCommerce\Bundle\CartBundle\Context\Front\CartContextInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotalDetailInterface;
use WellCommerce\Bundle\OrderBundle\Factory\OrderTotalFactory;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorTraverserInterface;

/**
 * Class OrderSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            'order.post_init'   => ['onOrderPostInitEvent', 0],
            'order.post_create' => ['onOrderPostCreateEvent', 0],
            'order.pre_update'  => ['onOrderPreUpdateEvent', 0],
        ];
    }
    
    public function onOrderPostInitEvent(ResourceEvent $event)
    {
        $order   = $event->getResource();
        $context = $this->getCartContext();
        if ($order instanceof OrderInterface && $context->hasCurrentCart()) {
            $order->setCart($context->getCurrentCart());
        }

        Debug::dump($order);die();
    }

    public function onOrderPostCreateEvent(ResourceEvent $event)
    {
        
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
            $this->removeTotals($order);
            $this->recalculateShippingTotal($order);
            $this->traverseOrder($order);
        }
    }
    
    protected function recalculateShippingTotal(OrderInterface $order)
    {
        $grossAmount = $order->getShippingTotal()->getGrossAmount();
        $taxRate     = $order->getShippingMethod()->getTax()->getValue();
        $currency    = $order->getCurrency();
        $orderTotal  = $this->getOrderTotalFactory()->createFromSpecifiedValues($grossAmount, $taxRate, $currency);
        
        $order->setShippingTotal($orderTotal);
    }
    
    protected function removeTotals(OrderInterface $order)
    {
        $em     = $this->getDoctrineHelper()->getEntityManager();
        $totals = $order->getTotals();
        $totals->map(function (OrderTotalDetailInterface $total) use ($em) {
            $em->remove($total);
        });
        
        $em->flush();
    }
    
    protected function traverseOrder(OrderInterface $order)
    {
        $this->getOrderVisitorTraverser()->traverse($order);
    }

    protected function getOrderVisitorTraverser() : OrderVisitorTraverserInterface
    {
        return $this->container->get('order.visitor.traverser');
    }

    protected function getCartManager() : CartManagerInterface
    {
        return $this->container->get('cart.manager.front');
    }

    protected function getCartContext() : CartContextInterface
    {
        return $this->container->get('cart.context.front');
    }

    protected function getOrderTotalFactory() : OrderTotalFactory
    {
        return $this->container->get('order_total.factory');
    }
}
