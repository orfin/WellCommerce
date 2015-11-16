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

namespace WellCommerce\Bundle\SalesBundle\Visitor;

use WellCommerce\Bundle\SalesBundle\Entity\CartInterface;

/**
 * Class CartPaymentMethodVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartPaymentMethodVisitor implements CartVisitorInterface
{
    /**
     * {@inheritdoc}
     */
    public function visitCart(CartInterface $cart)
    {
        $paymentMethod = $cart->getPaymentMethod();
        if (null !== $cart->getShippingMethodCost()) {
            $shippingMethod = $cart->getShippingMethodCost()->getShippingMethod();
            $collection     = $shippingMethod->getPaymentMethods();
            if (null === $paymentMethod || !$collection->contains($paymentMethod)) {
                $defaultPaymentMethod = $shippingMethod->getPaymentMethods()->first();
                $cart->setPaymentMethod($defaultPaymentMethod);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'payment_method';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 20;
    }
}
