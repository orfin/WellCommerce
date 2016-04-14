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
use WellCommerce\Bundle\PaymentBundle\Configurator\PaymentMethodConfiguratorInterface;
use WellCommerce\Bundle\PaymentBundle\Gateway\PaymentGatewayInterface;

/**
 * Class AbstractPaymentProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentProcessor extends AbstractContainerAware implements PaymentProcessorInterface
{
    /**
     * @var PaymentGatewayInterface
     */
    protected $gateway;
    
    /**
     * @var PaymentMethodConfiguratorInterface
     */
    protected $configurator;
    
    /**
     * AbstractPaymentProcessor constructor.
     *
     * @param PaymentGatewayInterface            $gateway
     * @param PaymentMethodConfiguratorInterface $configurator
     */
    public function __construct(PaymentGatewayInterface $gateway, PaymentMethodConfiguratorInterface $configurator)
    {
        $this->gateway      = $gateway;
        $this->configurator = $configurator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getGateway() : PaymentGatewayInterface
    {
        return $this->gateway;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfigurator() : PaymentMethodConfiguratorInterface
    {
        return $this->configurator;
    }
}
