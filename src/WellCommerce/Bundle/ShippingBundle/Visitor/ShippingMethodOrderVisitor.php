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

namespace WellCommerce\Bundle\ShippingBundle\Visitor;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Provider\OrderModifierProviderInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;
use WellCommerce\Bundle\ShippingBundle\Context\OrderContext;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class ShippingMethodCartVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ShippingMethodOrderVisitor implements OrderVisitorInterface
{
    /**
     * @var OrderModifierProviderInterface
     */
    private $modifierProvider;

    /**
     * @var
     */
    private $methodProvider;
    
    /**
     * ShippingMethodOrderVisitor constructor.
     *
     * @param OrderModifierProviderInterface  $modifierProvider
     * @param ShippingMethodProviderInterface $methodProvider
     */
    public function __construct(OrderModifierProviderInterface $modifierProvider, ShippingMethodProviderInterface $methodProvider)
    {
        $this->modifierProvider = $modifierProvider;
        $this->methodProvider   = $methodProvider;
    }
    
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $costs = $this->getCostCollection($order);
        
        if (0 === $costs->count()) {
            throw new \Exception('There are no possible shipping methods for cart');
        }
        
        $cost     = $costs->first();
        $modifier = $this->modifierProvider->getOrderModifier($order, 'shipping_cost');
        
        $modifier->setCurrency($cost->getShippingMethod()->getCurrency()->getCode());
        $modifier->setGrossAmount($cost->getCost()->getGrossAmount());
        $modifier->setNetAmount($cost->getCost()->getNetAmount());
        $modifier->setTaxAmount($cost->getCost()->getTaxAmount());
        
        $order->setShippingMethod($cost->getShippingMethod());
    }
    
    /**
     * Returns the costs collection for existing shipping method or all shipping methods if current method is not longer available
     *
     * @param OrderInterface $order
     *
     * @return Collection
     */
    private function getCostCollection(OrderInterface $order) : Collection
    {
        if ($order->hasShippingMethod()) {
            $costs = $this->getCurrentShippingMethodCostsCollection($order);
            if ($costs->count() > 0) {
                return $costs;
            }
        }
        
        return $this->getShippingCostCollection($order);
    }
    
    /**
     * Returns the collection of costs for all available shipping methods
     *
     * @param OrderInterface $order
     *
     * @return Collection
     */
    private function getShippingCostCollection(OrderInterface $order) : Collection
    {
        return $this->methodProvider->getCosts(new OrderContext($order));
    }
    
    /**
     * Returns the collection of costs for current shipping method
     *
     * @param OrderInterface $order
     *
     * @return Collection
     */
    private function getCurrentShippingMethodCostsCollection(OrderInterface $order) : Collection
    {
        return $this->methodProvider->getShippingMethodCosts($order->getShippingMethod(), new OrderContext($order));
    }
}
