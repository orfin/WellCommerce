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
     * @var PaymentManagerInterface
     */
    protected $paymentManager;
    
    /**
     * AbstractPaymentProcessor constructor.
     *
     * @param PaymentMethodConfiguratorInterface $configurator
     * @param PaymentManagerInterface            $paymentManager
     */
    public function __construct(PaymentMethodConfiguratorInterface $configurator, PaymentManagerInterface $paymentManager)
    {
        $this->paymentManager = $paymentManager;
        $this->configurator   = $configurator;
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
}
