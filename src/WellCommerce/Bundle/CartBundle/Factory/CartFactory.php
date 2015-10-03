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

namespace WellCommerce\Bundle\CartBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartTotals;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;

/**
 * Class CartFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartInterface
     */
    public function create()
    {
        $cart = new Cart();
        $cart->setProducts(new ArrayCollection());
        $cart->setTotals(new CartTotals());
        $cart->setShippingMethodCost(null);
        $cart->setPaymentMethod(null);
        $cart->setCopyAddress(true);
        $cart->setCoupon(null);

        return $cart;
    }
}
