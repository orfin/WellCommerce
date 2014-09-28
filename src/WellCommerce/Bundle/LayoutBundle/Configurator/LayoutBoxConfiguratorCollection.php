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

namespace WellCommerce\Bundle\LayoutBundle\Layout;

use WellCommerce\Bundle\LayoutBundle\LayoutBoxConfiguratorInterface;

/**
 * Class LayoutBoxConfiguratorCollection
 *
 * @package WellCommerce\Bundle\LayoutBundle\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxConfiguratorCollection
{
    /**
     * @var array An array containing all configurators in collection
     */
    protected $configurators = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->configurators);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->configurators);
    }

    /**
     * {@inheritdoc}
     */
    public function add($type, LayoutBoxConfiguratorInterface $configurator)
    {
        $this->configurators[$type] = $configurator;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->configurators;
    }
} 