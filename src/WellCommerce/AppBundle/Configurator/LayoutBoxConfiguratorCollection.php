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

namespace WellCommerce\AppBundle\Configurator;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class LayoutBoxConfiguratorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxConfiguratorCollection extends ArrayCollection
{
    /**
     * Adds new configurator to collection
     *
     * @param LayoutBoxConfiguratorInterface $configurator
     *
     * @throws \InvalidArgumentException If such configurator already exists in collection
     */
    public function add(LayoutBoxConfiguratorInterface $configurator)
    {
        $type = $configurator->getType();
        if ($this->has($type)) {
            throw new \InvalidArgumentException(sprintf('Layout box configurator "%s" already exists.', $type));
        }
        $this->items[$configurator->getType()] = $configurator;
    }
}
