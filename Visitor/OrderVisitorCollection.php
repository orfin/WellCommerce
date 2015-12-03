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

namespace WellCommerce\Bundle\OrderBundle\Visitor;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class OrderVisitorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderVisitorCollection extends ArrayCollection
{
    /**
     * @param OrderVisitorInterface $visitor
     */
    public function add(OrderVisitorInterface $visitor)
    {
        $this->items[$visitor->getAlias()] = $visitor;
    }

    /**
     * @return OrderVisitorInterface[]
     */
    public function all()
    {
        $this->sort();

        return $this->items;
    }

    private function sort()
    {
        usort($this->items, function (OrderVisitorInterface $a, OrderVisitorInterface $b) {
            if ($a->getPriority() === $b->getPriority()) {
                return 0;
            }

            return $a->getPriority() < $b->getPriority() ? -1 : 1;
        });
    }
}
