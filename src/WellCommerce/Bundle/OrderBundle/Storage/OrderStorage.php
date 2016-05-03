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
 * Class OrderStorage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderStorage implements OrderStorageInterface
{
    private $currentOrder;

    public function setCurrentOrder(OrderInterface $order)
    {
        $this->currentOrder = $order;
    }

    public function getCurrentOrder() : OrderInterface
    {
        return $this->currentOrder;
    }

    public function getCurrentOrderIdentifier() : int
    {
        if ($this->hasCurrentOrder()) {
            return $this->getCurrentOrder()->getId();
        }

        return 0;
    }

    public function hasCurrentOrder() : bool
    {
        return $this->currentOrder instanceof OrderInterface;
    }
}
