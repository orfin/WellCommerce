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

namespace WellCommerce\Bundle\CoreBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\ControllerInterface;

/**
 * Interface FrontControllerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontControllerInterface extends ControllerInterface
{
    const MASTER_CONTROLLER = 1;
    const SUB_CONTROLLER    = 2;
}
