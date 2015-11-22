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

namespace WellCommerce\AppBundle\Factory;

use WellCommerce\AppBundle\Entity\Route;
use WellCommerce\AppBundle\Factory\AbstractFactory;
use WellCommerce\AppBundle\Factory\FactoryInterface;

/**
 * Class RouteFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\AppBundle\Entity\RouteInterface
     */
    public function create()
    {
        $route = new Route();

        return $route;
    }
}
