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

namespace WellCommerce\AppBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\AppBundle\Factory\AbstractFactory;
use WellCommerce\AppBundle\Factory\FactoryInterface;
use WellCommerce\AppBundle\Entity\Cart;
use WellCommerce\AppBundle\Entity\CartTotals;

/**
 * Class CartFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\AppBundle\Entity\CartInterface
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
