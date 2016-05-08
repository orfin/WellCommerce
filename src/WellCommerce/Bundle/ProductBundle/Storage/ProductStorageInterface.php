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

namespace WellCommerce\Bundle\ProductBundle\Storage;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface ProductStorageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductStorageInterface
{
    /**
     * @param ProductInterface $product
     */
    public function setCurrentProduct(ProductInterface $product);

    /**
     * @return ProductInterface
     */
    public function getCurrentProduct() : ProductInterface;

    /**
     * @return bool
     */
    public function hasCurrentProduct() : bool;
}
