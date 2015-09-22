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
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface CartProductFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductFactoryInterface extends FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartProductInterface
     */
    public function create();

    /**
     * Creates an instance of cart product
     *
     * @param CartInterface                  $cart
     * @param ProductInterface               $product
     * @param ProductAttributeInterface|null $attribute
     * @param int                            $quantity
     *
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartProductInterface
     */
    public function createCartProduct(CartInterface $cart, ProductInterface $product, ProductAttributeInterface $attribute = null, $quantity = 1);
}
