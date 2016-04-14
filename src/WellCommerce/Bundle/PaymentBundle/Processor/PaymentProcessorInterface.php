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

use WellCommerce\Bundle\PaymentBundle\Configurator\PaymentMethodConfiguratorInterface;
use WellCommerce\Bundle\PaymentBundle\Gateway\PaymentGatewayInterface;

/**
 * Interface PaymentProcessorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentProcessorInterface
{
    /**
     * @return PaymentGatewayInterface
     */
    public function getGateway() : PaymentGatewayInterface;

    /**
     * @return PaymentMethodConfiguratorInterface
     */
    public function getConfigurator() : PaymentMethodConfiguratorInterface;
}
