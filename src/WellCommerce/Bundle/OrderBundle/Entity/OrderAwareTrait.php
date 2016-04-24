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

namespace WellCommerce\Bundle\OrderBundle\Entity;

/**
 * Class OrderAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait OrderAwareTrait
{
    protected $order;

    public function getOrder() : OrderInterface
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }

    public function hasOrder() : bool
    {
        return $this->order instanceof OrderInterface;
    }
}
