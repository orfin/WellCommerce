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

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class CartProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductFactory extends AbstractFactory implements CartProductFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $cartProduct = new CartProduct();
        $cartProduct->setCreatedAt(new \DateTime());
        $cartProduct->setUpdatedAt(new \DateTime());

        return $cartProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function createCartProduct(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null, $quantity = 1)
    {
        $cartProduct = $this->create();
        $cartProduct->setCart($cart);
        $cartProduct->setProduct($product);
        $cartProduct->setAttribute($attribute);
        $cartProduct->setQuantity($quantity);

        return $cartProduct;
    }
}
