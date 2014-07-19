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

namespace WellCommerce\PayPal\Configurator;

use WellCommerce\Core\Event\FormEvent;
use WellCommerce\PaymentMethod\Configurator\AbstractPaymentMethodConfigurator;
use WellCommerce\PaymentMethod\Configurator\PaymentMethodConfiguratorInterface;

/**
 * Class PayPalConfigurator
 *
 * @package WellCommerce\PayPal\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalConfigurator extends AbstractPaymentMethodConfigurator implements PaymentMethodConfiguratorInterface
{

    public function addConfigurationFields(FormEvent $event)
    {

    }

    public function addPaymentMethodConfiguration()
    {

    }

} 