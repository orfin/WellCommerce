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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Interface OrderManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderManagerInterface extends ManagerInterface
{
    public function findOrder(string $currency, string $sessionId, ClientInterface $client = null, ShopInterface $shop) : OrderInterface;
}
