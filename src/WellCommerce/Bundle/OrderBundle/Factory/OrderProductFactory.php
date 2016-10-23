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

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;

/**
 * Class OrderProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductFactory extends AbstractEntityFactory
{
    public function create() : OrderProductInterface
    {
        $orderProduct = new OrderProduct();
        $orderProduct->setQuantity(1);
        $orderProduct->setWeight(0);
        $orderProduct->setBuyPrice(new Price());
        $orderProduct->setSellPrice(new DiscountablePrice());
        $orderProduct->setCreatedAt(new \DateTime());
        $orderProduct->setUpdatedAt(new \DateTime());
        $orderProduct->setOptions([]);
        $orderProduct->setLocked(false);
        
        return $orderProduct;
    }
}
