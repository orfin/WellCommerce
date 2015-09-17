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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;

/**
 * Class OrderProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface
     */
    public function create()
    {
        $orderProduct = new OrderProduct();
        $orderProduct->setGrossPrice(0);
        $orderProduct->setNetPrice(0);
        $orderProduct->setQuantity(0);
        $orderProduct->setTaxValue(0);
        $orderProduct->setWeight(0);

        return $orderProduct;
    }
}
