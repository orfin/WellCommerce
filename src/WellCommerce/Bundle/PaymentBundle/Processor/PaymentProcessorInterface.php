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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Configurator\PaymentMethodConfiguratorInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;

/**
 * Interface PaymentProcessorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentProcessorInterface
{
    /**
     * Returns the configurator
     *
     * @return PaymentMethodConfiguratorInterface
     */
    public function getConfigurator() : PaymentMethodConfiguratorInterface;

    /**
     * Returns the configuration for payment method
     *
     * @param PaymentMethodInterface $paymentMethod
     *
     * @return array
     */
    public function getConfiguration(PaymentMethodInterface $paymentMethod) : array;

    /**
     * Returns the initialization URL for current payment processor
     *
     * @return string
     */
    public function getInitializeUrl() : string;

    /**
     * Prepares the payment for order
     *
     * @param PaymentInterface $payment
     * @param OrderInterface   $order
     */
    public function preparePaymentForOrder(PaymentInterface $payment, OrderInterface $order);
}
