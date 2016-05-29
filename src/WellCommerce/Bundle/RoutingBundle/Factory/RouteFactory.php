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

namespace WellCommerce\Bundle\RoutingBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class RouteFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteFactory extends AbstractEntityFactory
{
    public function create() : RouteInterface
    {
        /** @var  $route RouteInterface */
        $route = $this->init();

        return $route;
    }
}
