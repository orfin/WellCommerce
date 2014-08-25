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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Box;

/**
 * Class LayoutBoxCollection
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array An array containing all boxes in collection
     */
    public $boxes = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->boxes);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->boxes);
    }

    /**
     * {@inheritdoc}
     */
    public function add(LayoutBox $layoutBox)
    {
        $this->boxes[] = $layoutBox;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->boxes;
    }
}