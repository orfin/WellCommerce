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

namespace WellCommerce\Bundle\CommonBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\CommonBundle\Entity\Route;

/**
 * Class RouteFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\CommonBundle\Entity\RouteInterface
     */
    public function create()
    {
        $route = new Route();

        return $route;
    }
}
