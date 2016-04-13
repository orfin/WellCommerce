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

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
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
    /**
     * @var OrderVisitorTraverserInterface
     */
    protected $orderVisitorTraverser;
    
    /**
     * @var OrderTotalFactory
     */
    protected $orderTotalFactory;
    
    /**
     * OrderSubscriber constructor.
     *
     * @param OrderVisitorTraverserInterface $orderVisitorTraverser
     * @param OrderTotalFactory              $orderTotalFactory
     */
    public function __construct(OrderVisitorTraverserInterface $orderVisitorTraverser, OrderTotalFactory $orderTotalFactory)
    {
        $this->orderVisitorTraverser = $orderVisitorTraverser;
        $this->orderTotalFactory     = $orderTotalFactory;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            'order.post_prepared' => ['onOrderPostPreparedEvent', 0],
            'order.pre_update'    => ['onOrderPreUpdateEvent', 0],
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
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

    public function onKernelRequest(GetResponseEvent $event)
    {
        $session    = $event->getRequest()->getSession();
        $repository = $this->container->get('order.repository');
        $context    = $this->container->get('order.context.front');

        if ($session->has('orderId')) {
            $order = $repository->find($session->get('orderId'));
            if ($order instanceof OrderInterface) {
                $context->setCurrentOrder($order);
            }
        }
    }
    
    protected function recalculateShippingTotal(OrderInterface $order)
    {
        $grossAmount = $order->getShippingTotal()->getGrossAmount();
        $taxRate     = $order->getShippingMethod()->getTax()->getValue();
        $currency    = $order->getCurrency();
        $orderTotal  = $this->orderTotalFactory->createFromSpecifiedValues($grossAmount, $taxRate, $currency);
        
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
        $this->orderVisitorTraverser->traverse($order);
    }
}
