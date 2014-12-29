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

namespace WellCommerce\Bundle\CoreBundle\Collection;

/**
 * Class AbstractCollection
 *
 * @package WellCommerce\Bundle\CoreBundle\Collection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var array An array containing all items in collection
     */
    protected $items = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Checks whether such key exists in collection
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Returns a collection element by its key
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->items[$key];
    }

    public function forAll(\Closure $callable)
    {
        foreach ($this->items as $key => $item) {
            return $callable($item);
        }
    }
}