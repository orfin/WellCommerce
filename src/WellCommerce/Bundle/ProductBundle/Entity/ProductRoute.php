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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use WellCommerce\Bundle\RoutingBundle\Entity\Route;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class ProductRoute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductRoute extends Route implements RouteInterface
{
    /**
     * @var ProductInterface
     */
    protected $identifier;

    /**
     * @return string
     */
    public function getType() : string
    {
        return 'product';
    }
}
