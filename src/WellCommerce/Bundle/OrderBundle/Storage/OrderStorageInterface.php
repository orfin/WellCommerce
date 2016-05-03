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

namespace WellCommerce\Bundle\OrderBundle\Storage;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Interface OrderStorageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderStorageInterface
{
    public function setCurrentOrder(OrderInterface $order);

    public function getCurrentOrder() : OrderInterface;

    public function getCurrentOrderIdentifier() : int;

    public function hasCurrentOrder() : bool;
}
