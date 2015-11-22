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

namespace WellCommerce\SalesBundle\Visitor;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class CartVisitorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartVisitorCollection extends ArrayCollection
{
    /**
     * @param CartVisitorInterface $visitor
     */
    public function add(CartVisitorInterface $visitor)
    {
        $this->items[$visitor->getAlias()] = $visitor;
    }

    /**
     * @return CartVisitorInterface[]
     */
    public function all()
    {
        $this->sort();

        return $this->items;
    }

    private function sort()
    {
        usort($this->items, function (CartVisitorInterface $a, CartVisitorInterface $b) {
            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }

            return $a->getPriority() < $b->getPriority() ? -1 : 1;
        });
    }
}
