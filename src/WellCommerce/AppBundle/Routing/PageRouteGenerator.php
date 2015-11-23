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

namespace WellCommerce\AppBundle\Routing;

use WellCommerce\AppBundle\Generator\AbstractRouteGenerator;
use WellCommerce\AppBundle\Generator\RouteGeneratorInterface;

/**
 * Class PageRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageRouteGenerator extends AbstractRouteGenerator implements RouteGeneratorInterface
{
    const GENERATOR_STRATEGY = 'page';

    public function supports($strategy)
    {
        return self::GENERATOR_STRATEGY === $strategy;
    }
}
