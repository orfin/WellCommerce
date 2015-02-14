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

namespace WellCommerce\Bundle\SeoBundle\Routing;

use WellCommerce\Bundle\RoutingBundle\Generator\AbstractRouteGenerator;
use WellCommerce\Bundle\RoutingBundle\Generator\RouteGeneratorInterface;

/**
 * Class SeoRouteGenerator
 *
 * @package WellCommerce\Bundle\SeoBundle\Routing
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SeoRouteGenerator extends AbstractRouteGenerator implements RouteGeneratorInterface
{
    const GENERATOR_STRATEGY = 'producer';

    public function supports($strategy)
    {
        return self::GENERATOR_STRATEGY === $strategy;
    }
}
