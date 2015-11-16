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

namespace WellCommerce\Bundle\SalesBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\SalesBundle\Entity\CartProduct;

/**
 * Class CartProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\SalesBundle\Entity\CartProductInterface
     */
    public function create()
    {
        $cartProduct = new CartProduct();
        $cartProduct->setCreatedAt(new \DateTime());
        $cartProduct->setUpdatedAt(new \DateTime());

        return $cartProduct;
    }
}
