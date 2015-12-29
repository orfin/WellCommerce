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

namespace WellCommerce\Bundle\ProductStatusBundle\Routing;

use WellCommerce\Bundle\RoutingBundle\Generator\AbstractRouteGenerator;

/**
 * Class ProductStatusRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusRouteGenerator extends AbstractRouteGenerator
{
    const GENERATOR_STRATEGY = 'product_status';

    public function supports($strategy)
    {
        return self::GENERATOR_STRATEGY === $strategy;
    }
}
