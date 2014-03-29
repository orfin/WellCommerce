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

namespace WellCommerce\Core\Layout\Box;

/**
 * Class BoxCollection
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxCollection implements \IteratorAggregate, \Countable
{
    public $boxes = [];

    public function getIterator()
    {
        return new \ArrayIterator($this->boxes);
    }

    public function count()
    {
        return count($this->boxes);
    }

    public function add(LayoutBox $layoutBox)
    {
        $this->boxes[] = $layoutBox;
    }

    public function all()
    {
        return $this->boxes;
    }
}