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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Page;

use WellCommerce\Bundle\LayoutBundle\Manager\Layout;

/**
 * Class LayoutPageCollection
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager\Page
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    public $pages = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->pages);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->pages);
    }

    /**
     * {@inheritdoc}
     */
    public function add(Layout $layout)
    {
        $this->pages[] = $layout;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->pages;
    }
}