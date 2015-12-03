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

namespace WellCommerce\Bundle\CartBundle\Visitor;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Class CartVisitorTraverser
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartVisitorTraverser implements CartVisitorTraverserInterface
{
    /**
     * @var CartVisitorCollection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param CartVisitorCollection $collection
     */
    public function __construct(CartVisitorCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function traverse(CartInterface $cart)
    {
        foreach ($this->collection->all() as $visitor) {
            $visitor->visitCart($cart);
        }
    }
}
