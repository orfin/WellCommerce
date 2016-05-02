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

namespace WellCommerce\Component\Collections;

use ArrayIterator;
use Closure;

/**
 * Class ArrayCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ArrayCollection implements CollectionInterface
{
    /**
     * @var array An array containing all items in collection
     */
    protected $items = [];
    
    /**
     * Initializes a new ArrayCollection.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
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
    
    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->items);
    }
    
    /**
     * Removes an item from collection
     *
     * @param string $key
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
        }
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
        return array_key_exists($key, $this->items);
    }
    
    /**
     * Checks whether such item exists in collection
     *
     * @param $item
     *
     * @return bool
     */
    public function contains($item)
    {
        return in_array($item, $this->items);
    }
    
    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->items);
    }
    
    /**
     * @param Closure $callable
     */
    public function forAll(Closure $callable)
    {
        foreach ($this->items as $key => $item) {
            $callable($item);
        }
    }
}
