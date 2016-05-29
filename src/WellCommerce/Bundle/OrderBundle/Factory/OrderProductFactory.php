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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
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
        /** @var  $orderProduct OrderProductInterface */
        $orderProduct = $this->init();
        $orderProduct->setQuantity(1);
        $orderProduct->setWeight(0);
        $orderProduct->setBuyPrice($this->createPrice());
        $orderProduct->setSellPrice($this->createPrice());
        $orderProduct->setCreatedAt(new \DateTime());
        $orderProduct->setUpdatedAt(new \DateTime());
        $orderProduct->setOptions([]);
        
        return $orderProduct;
    }
}
