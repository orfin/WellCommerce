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

namespace WellCommerce\Core\Component\Controller\Front;

use WellCommerce\Core\Layout\LayoutInterface;

/**
 * Interface FrontControllerInterface
 *
 * @package WellCommerce\Core\Component\Controller\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontControllerInterface
{
    const MASTER_CONTROLLER = 1;
    const SUB_CONTROLLER    = 2;

    /**
     * Initializes layout for controller
     *
     * @param      $name
     * @param bool $cache Is cache enabled
     * @param int  $ttl   Cache lifetime
     */

    public function setLayout($name, $cache = true, $ttl = LayoutInterface::CACHE_TTL);

    /**
     * Returns rendered layout
     *
     * @return mixed
     * @throws \LogicException
     */
    public function renderLayout();
}