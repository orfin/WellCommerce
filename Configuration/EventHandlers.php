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

namespace WellCommerce\Component\DataGrid\Configuration;

use WellCommerce\Component\DataGrid\Configuration\EventHandler\EventHandlerInterface;

/**
 * Class EventHandlers
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EventHandlers implements \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    private $eventHandlers;

    /**
     * Returns iterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->eventHandlers);
    }

    /**
     * Returns events count
     *
     * @return int
     */
    public function count() : int
    {
        return count($this->eventHandlers);
    }

    /**
     * Returns all event handlers
     *
     * @return array
     */
    public function all() : array
    {
        return $this->eventHandlers;
    }

    /**
     * Adds new event handler to collection
     *
     * @param EventHandlerInterface $eventHandler
     */
    public function add(EventHandlerInterface $eventHandler)
    {
        $this->eventHandlers[$eventHandler->getFunctionName()] = $eventHandler;
    }

    /**
     * Returns chosen event handler by its function name
     *
     * @param $name
     *
     * @return EventHandlerInterface
     * @throws \InvalidArgumentException
     */
    public function get(string $name) : EventHandlerInterface
    {
        if (!isset($this->eventHandlers[$name])) {
            throw new \InvalidArgumentException(sprintf('DataGrid event handler %s not found', $name));
        }

        return $this->eventHandlers[$name];
    }

    /**
     * Returns string containing all DataGrid options
     *
     * @return string
     */
    public function __toString() : string
    {
        $attributes = [];
        foreach ($this->all() as $eventHandlerName => $options) {
            $attributes[] = sprintf('%s: %s', $eventHandlerName, $options['function']);
        }

        return implode(",\n", $attributes);
    }
}
