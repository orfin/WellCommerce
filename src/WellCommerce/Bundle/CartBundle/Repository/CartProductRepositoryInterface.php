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

namespace WellCommerce\Bundle\CartBundle\Repository;

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Interface CartProductRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns product from cart
     *
     * @param Cart             $cart
     * @param Product          $product
     * @param ProductAttribute $attribute
     *
     * @return null|\WellCommerce\Bundle\CartBundle\Entity\CartProduct
     */
    public function findProductInCart(Cart $cart, Product $product, ProductAttribute $attribute = null);
}
