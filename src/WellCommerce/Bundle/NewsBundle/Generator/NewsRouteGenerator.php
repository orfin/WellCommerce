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

namespace WellCommerce\Bundle\NewsBundle\Generator;

use WellCommerce\Bundle\RoutingBundle\Generator\AbstractRouteGenerator;

/**
 * Class NewsRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsRouteGenerator extends AbstractRouteGenerator
{
    const GENERATOR_STRATEGY = 'news';

    public function supports($strategy)
    {
        return self::GENERATOR_STRATEGY === $strategy;
    }
}
