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
use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartModifierManager;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartModifierManagerInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;
use WellCommerce\Bundle\ShippingBundle\Context\CartContext;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class ShippingMethodCartVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ShippingMethodCartVisitor implements CartVisitorInterface
{
    /**
     * @var CartModifierManagerInterface
     */
    private $cartModifierManager;
    
    /**
     * ShippingMethodCartVisitor constructor.
     *
     * @param CartModifierManagerInterface $cartModifierManager
     */
    public function __construct(CartModifierManagerInterface $cartModifierManager)
    {
        $this->cartModifierManager = $cartModifierManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $costs = $this->getCostCollection($cart);
        
        if (0 === $costs->count()) {
            throw new \Exception('There are no possible shipping methods for cart');
        }
        
        $cost     = $costs->first();
        $modifier = $this->cartModifierManager->getCartModifier($cart, 'shipping_cost');

        $modifier->setCurrency($cost->getShippingMethod()->getCurrency()->getCode());
        $modifier->setGrossAmount($cost->getCost()->getGrossAmount());
        $modifier->setNetAmount($cost->getCost()->getNetAmount());
        $modifier->setTaxAmount($cost->getCost()->getTaxAmount());

        $cart->setShippingMethod($cost->getShippingMethod());
    }

    /**
     * Returns the costs collection for existing shipping method or all shipping methods if current method is not longer available
     *
     * @param CartInterface $cart
     *
     * @return Collection
     */
    private function getCostCollection(CartInterface $cart) : Collection
    {
        if ($cart->hasShippingMethod()) {
            $costs = $this->getCurrentShippingMethodCostsCollection($cart);
            if ($costs->count() > 0) {
                return $costs;
            }
        }
        
        return $this->getShippingCostCollection($cart);
    }

    /**
     * Returns the collection of costs for all available shipping methods
     *
     * @param CartInterface $cart
     *
     * @return Collection
     */
    private function getShippingCostCollection(CartInterface $cart) : Collection
    {
        return $this->getShippingMethodProvider()->getCosts(new CartContext($cart));
    }

    /**
     * Returns the collection of costs for current shipping method
     *
     * @param CartInterface $cart
     *
     * @return Collection
     */
    private function getCurrentShippingMethodCostsCollection(CartInterface $cart) : Collection
    {
        return $this->getShippingMethodProvider()->getShippingMethodCosts($cart->getShippingMethod(), new CartContext($cart));
    }

    private function getShippingMethodProvider() : ShippingMethodProviderInterface
    {
        return $this->cartModifierManager->get('shipping_method.provider');
    }
}
