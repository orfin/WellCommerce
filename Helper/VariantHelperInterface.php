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

namespace WellCommerce\Bundle\ProductBundle\Helper;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Interface VariantHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface VariantHelperInterface
{
    public function getVariants(ProductInterface $product) : array;

    public function getAttributes(ProductInterface $product) : array;

    public function getVariantOptions(VariantInterface $variant) : array;
}
