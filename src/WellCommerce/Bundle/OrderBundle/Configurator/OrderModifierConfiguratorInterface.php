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

namespace WellCommerce\Bundle\OrderBundle\Configurator;

use WellCommerce\Bundle\OrderBundle\Entity\OrderModifierInterface;

/**
 * Class OrderModifierConfiguratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderModifierConfiguratorInterface
{
    /**
     * Configures the order modifier
     *
     * @param OrderModifierInterface $modifier
     */
    public function configure(OrderModifierInterface $modifier);
}
