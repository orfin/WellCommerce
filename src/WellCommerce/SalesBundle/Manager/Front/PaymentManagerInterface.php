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

namespace WellCommerce\SalesBundle\Manager\Front;

use WellCommerce\SalesBundle\Entity\OrderInterface;

/**
 * Interface PaymentManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentManagerInterface
{
    /**
     * Finds order by its id or throws an exception
     *
     * @return OrderInterface
     * @throws \WellCommerce\SalesBundle\Exception\OrderNotFoundException
     */
    public function findOrder();

    /**
     * @param OrderInterface $order
     */
    public function registerPayment(OrderInterface $order);
}
