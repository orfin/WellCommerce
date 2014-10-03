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

namespace WellCommerce\Bundle\LayoutBundle\Layout\Configurator;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;
use WellCommerce\Bundle\LayoutBundle\LayoutBoxConfiguratorInterface;

/**
 * Class LayoutBoxConfiguratorCollection
 *
 * @package WellCommerce\Bundle\LayoutBundle\Layout\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxConfiguratorCollection extends AbstractCollection
{
    /**
     * Adds new configurator to collection
     *
     * @param                                $type
     * @param LayoutBoxConfiguratorInterface $configurator
     */
    public function add($type, LayoutBoxConfiguratorInterface $configurator)
    {
        $this->items[$type] = $configurator;
    }
}