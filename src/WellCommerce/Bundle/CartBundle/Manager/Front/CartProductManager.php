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

namespace WellCommerce\Bundle\CartBundle\Manager\Front;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class CartProductManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductManager extends AbstractFrontManager implements CartProductManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function initCartProduct(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null, $quantity = 1)
    {
        $cartProduct = $this->initResource();
        $cartProduct->setCart($cart);
        $cartProduct->setProduct($product);
        $cartProduct->setAttribute($attribute);
        $cartProduct->setQuantity($quantity);

        $this->createResource($cartProduct);

        return $cartProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function findProductInCart(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null)
    {
        return $this->getRepository()->findOneBy([
            'cart'      => $cart,
            'product'   => $product,
            'attribute' => $attribute
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function changeCartProductQuantity(CartProductInterface $cartProduct, $qty)
    {
        $qty = (int)$qty;

        if ($qty < 1) {
            $this->removeResource($cartProduct);
        } else {
            $cartProduct->setQuantity($qty);
            $this->updateResource($cartProduct);
        }
    }
}
