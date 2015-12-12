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

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;

/**
 * Class OrderProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $orderProduct = new OrderProduct();
        $orderProduct->setQuantity(0);
        $orderProduct->setWeight(0);

        return $orderProduct;
    }
}
