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

namespace WellCommerce\Bundle\PaymentBundle\Visitor;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartModifierManagerInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorInterface;

/**
 * Class PaymentMethodCartVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PaymentMethodCartVisitor implements CartVisitorInterface
{
    /**
     * @var CartModifierManagerInterface
     */
    private $cartModifierManager;

    /**
     * PaymentMethodCartVisitor constructor.
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
        $shippingMethod = $cart->getShippingMethod();
        $paymentMethods = $shippingMethod->getPaymentMethods();

        if (false === $cart->hasPaymentMethod() || false === $paymentMethods->contains($cart->getPaymentMethod())) {
            $cart->setPaymentMethod($paymentMethods->first());
        }

        $modifier = $this->cartModifierManager->getCartModifier($cart, 'payment_surcharge');
        $modifier->setCurrency($cart->getCurrency());
        $modifier->setGrossAmount(0);
        $modifier->setNetAmount(0);
        $modifier->setTaxAmount(0);
    }
}
