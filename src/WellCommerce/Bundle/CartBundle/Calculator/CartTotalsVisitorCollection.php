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

use WellCommerce\Bundle\CartBundle\Calculator\CartTotalsVisitorInterface;
use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class CartTotalsVisitorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotalsVisitorCollection extends ArrayCollection
{
    /**
     * @param CartTotalsVisitorInterface $cartTotalsVisitor
     */
    public function add(CartTotalsVisitorInterface $cartTotalsVisitor)
    {
        $this->items[$cartTotalsVisitor->getAlias()] = $cartTotalsVisitor;
    }

    /**
     * Returns all visitors sorted by priority
     *
     * @return CartTotalsVisitorInterface[]
     */
    public function all()
    {
        usort($this->items, function (CartTotalsVisitorInterface $a, CartTotalsVisitorInterface $b) {
            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }

            return $a->getPriority() < $b->getPriority() ? -1 : 1;
        });

        return $this->items;
    }
}
