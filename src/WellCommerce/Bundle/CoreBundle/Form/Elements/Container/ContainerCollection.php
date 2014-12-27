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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Container;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ContainerCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ContainerCollection extends AbstractCollection
{
    /**
     * Adds new container to collection
     *
     * @param ContainerInterface $container
     */
    public function add(ContainerInterface $container)
    {
        $this->items[$container->getName()] = $container;
    }
} 