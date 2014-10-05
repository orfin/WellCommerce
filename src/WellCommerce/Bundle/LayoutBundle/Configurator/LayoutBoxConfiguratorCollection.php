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

namespace WellCommerce\Bundle\LayoutBundle\Configurator;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class LayoutBoxConfiguratorCollection
 *
 * @package WellCommerce\Bundle\LayoutBundle\Configurator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxConfiguratorCollection extends AbstractCollection
{
    /**
     * Adds new configurator to collection
     *
     * @param LayoutBoxConfiguratorInterface $configurator
     *
     * @return void
     */
    public function add(LayoutBoxConfiguratorInterface $configurator)
    {
        $this->items[] = $configurator;
    }
}