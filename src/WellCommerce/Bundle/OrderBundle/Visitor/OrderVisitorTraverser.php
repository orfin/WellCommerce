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

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderVisitorTraverser
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderVisitorTraverser implements OrderVisitorTraverserInterface
{
    /**
     * @var OrderVisitorCollection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param OrderVisitorCollection $collection
     */
    public function __construct(OrderVisitorCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function traverse(OrderInterface $order)
    {
        foreach ($this->collection->all() as $visitor) {
            $visitor->visitOrder($order);
        }
    }
}
