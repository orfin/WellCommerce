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

namespace WellCommerce\Bundle\CartBundle\Helper;

use WellCommerce\Bundle\CartBundle\Entity\Cart;

/**
 * Interface CartHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartHelperInterface
{
    /**
     * Recalculates cart totals
     *
     * @param Cart $cart
     *
     * @return bool
     */
    public function recalculateCartTotals(Cart $cart);
}
