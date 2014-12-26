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

namespace WellCommerce\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\RoutingBundle\Entity\Route;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="route_page")
 */
class PageRoute extends Route implements RouteInterface
{
    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CmsBundle\Entity\Page")
     * @ORM\JoinColumn(name="foreign_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $identifier;
} 