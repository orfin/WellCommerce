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

namespace WellCommerce\SalesBundle\Factory;

use WellCommerce\CoreBundle\Factory\FactoryInterface;
use WellCommerce\SalesBundle\Entity\CartInterface;

/**
 * Interface OrderFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderFactoryInterface extends FactoryInterface
{
    /**
     * Initializes order from cart object
     *
     * @param CartInterface $cart
     *
     * @return \WellCommerce\SalesBundle\Entity\OrderInterface
     */
    public function createOrderFromCart(CartInterface $cart);
}
