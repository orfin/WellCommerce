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

namespace WellCommerce\Bundle\SalesBundle\Collector;

use WellCommerce\Bundle\SalesBundle\Entity\CartInterface;

/**
 * Class CartSummaryCollectorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartSummaryCollectorInterface
{
    /**
     * Collects summary from cart
     *
     * @param CartInterface $cart
     */
    public function collect(CartInterface $cart);
}
