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

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Provider\OrderModifierProviderInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorInterface;

/**
 * Class PaymentMethodOrderVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PaymentMethodOrderVisitor implements OrderVisitorInterface
{
    /**
     * @var OrderModifierProviderInterface
     */
    private $orderModifierProvider;

    /**
     * PaymentMethodOrderVisitor constructor.
     *
     * @param OrderModifierProviderInterface $orderModifierProvider
     */
    public function __construct(OrderModifierProviderInterface $orderModifierProvider)
    {
        $this->orderModifierProvider = $orderModifierProvider;
    }
    
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $shippingMethod = $order->getShippingMethod();
        $paymentMethods = $shippingMethod->getPaymentMethods();

        if (false === $order->hasPaymentMethod() || false === $paymentMethods->contains($order->getPaymentMethod())) {
            $order->setPaymentMethod($paymentMethods->first());
        }

        $modifier = $this->orderModifierProvider->getOrderModifier($order, 'payment_surcharge');
        $modifier->setCurrency($order->getCurrency());
        $modifier->setGrossAmount(0);
        $modifier->setNetAmount(0);
        $modifier->setTaxAmount(0);
    }
}
