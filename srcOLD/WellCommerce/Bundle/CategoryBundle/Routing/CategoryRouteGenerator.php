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

namespace WellCommerce\Bundle\CategoryBundle\Routing;

use WellCommerce\Bundle\RoutingBundle\Generator\AbstractRouteGenerator;

/**
 * Class CategoryRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRouteGenerator extends AbstractRouteGenerator
{
    const GENERATOR_STRATEGY = 'category';

    /**
     * {@inheritdoc}
     */
    public function supports($strategy)
    {
        return self::GENERATOR_STRATEGY === $strategy;
    }
}
