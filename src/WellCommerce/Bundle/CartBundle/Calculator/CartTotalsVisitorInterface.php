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

namespace WellCommerce\Bundle\CartBundle\Calculator;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Interface CartTotalsVisitorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartTotalsVisitorInterface
{
    /**
     * @param CartInterface $cart
     */
    public function visitCart(CartInterface $cart);

    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return int
     */
    public function getPriority();
}
