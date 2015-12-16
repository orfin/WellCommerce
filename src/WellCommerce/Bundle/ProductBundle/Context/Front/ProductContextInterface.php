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

namespace WellCommerce\Bundle\ProductBundle\Context\Front;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface ProductContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductContextInterface
{
    /**
     * @param ProductInterface $product
     */
    public function setCurrentProduct(ProductInterface $product);

    /**
     * @return null|ProductInterface
     */
    public function getCurrentProduct();

    /**
     * @return bool
     */
    public function hasCurrentProduct();
}
