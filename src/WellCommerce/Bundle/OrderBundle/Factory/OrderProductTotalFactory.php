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

namespace WellCommerce\Bundle\OrderBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductTotal;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductTotalInterface;

/**
 * Class OrderProductTotalFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderProductTotalFactory extends AbstractEntityFactory
{
    public function create() : OrderProductTotalInterface
    {
        return new OrderProductTotal();
    }
}
