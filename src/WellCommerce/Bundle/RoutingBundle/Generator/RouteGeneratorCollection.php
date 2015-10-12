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

namespace WellCommerce\Bundle\RoutingBundle\Generator;

use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class RouteGeneratorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteGeneratorCollection extends ArrayCollection
{
    /**
     * @param RouteGeneratorInterface $generator
     */
    public function add(RouteGeneratorInterface $generator)
    {
        $this->items[] = $generator;
    }

    /**
     * @return RouteGeneratorInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
