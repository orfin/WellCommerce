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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\PaymentBundle\Configurator\PaymentMethodConfiguratorInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface;

/**
 * Class AbstractPaymentProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentProcessor extends AbstractContainerAware implements PaymentProcessorInterface
{
    /**
     * @var PaymentManagerInterface
     */
    protected $configurator;
    
    /**
     * AbstractPaymentProcessor constructor.
     *
     * @param PaymentMethodConfiguratorInterface $configurator
     */
    public function __construct(PaymentMethodConfiguratorInterface $configurator)
    {
        $this->configurator = $configurator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfigurator() : PaymentMethodConfiguratorInterface
    {
        return $this->configurator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(PaymentMethodInterface $paymentMethod) : array
    {
        $this->configurator->configure($paymentMethod);
        
        return $this->configurator->getConfiguration();
    }
    
    /**
     * {@inheritdoc}
     */
    public function preparePaymentForOrder(PaymentInterface $payment, OrderInterface $order)
    {
        $payment->setOrder($order);
        $payment->setState(PaymentInterface::PAYMENT_STATE_CREATED);
        $payment->setProcessor($this->getConfigurator()->getName());
        $payment->setConfiguration($this->getConfiguration($order->getPaymentMethod()));
    }
}
