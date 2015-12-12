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
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;

/**
 * Class OrderProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = OrderProductInterface::class;

    /**
     * @return OrderProductInterface
     */
    public function create()
    {
        /** @var  $orderProduct OrderProductInterface */
        $orderProduct = $this->init();
        $orderProduct->setQuantity(0);
        $orderProduct->setWeight(0);

        return $orderProduct;
    }
}
