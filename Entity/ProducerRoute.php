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

namespace WellCommerce\Bundle\ProducerBundle\Entity;

use WellCommerce\Bundle\RoutingBundle\Entity\Route;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class ProducerRoute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerRoute extends Route implements RouteInterface
{
    /**
     * @var ProducerInterface
     */
    protected $identifier;

    public function getType() : string
    {
        return 'producer';
    }
}
