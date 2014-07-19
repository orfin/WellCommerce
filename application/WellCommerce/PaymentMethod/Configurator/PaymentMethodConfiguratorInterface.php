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

namespace WellCommerce\PaymentMethod\Configurator;

use WellCommerce\Core\Event\FormEvent;

/**
 * Interface PaymentMethodConfiguratorInterface
 *
 * @package WellCommerce\PaymentMethod\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodConfiguratorInterface
{
    /**
     * Prepares payment method configuration fields
     *
     * @param FormEvent $event
     *
     * @return mixed
     */
    public function addConfigurationFields(FormEvent $event);

    /**
     * Adds payment method configuration fields to form fieldset
     *
     * @return mixed
     */
    public function addPaymentMethodConfiguration();
}