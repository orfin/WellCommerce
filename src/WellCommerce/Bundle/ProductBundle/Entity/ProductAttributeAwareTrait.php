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

namespace WellCommerce\Bundle\ProductBundle\Entity;


trait ProductAttributeAwareTrait
{
    /**
     * @var null|ProductAttributeInterface
     */
    protected $productAttribute;

    /**
     * @return null|ProductAttributeInterface
     */
    public function getProductAttribute()
    {
        return $this->productAttribute;
    }

    /**
     * @param null|ProductAttributeInterface $productAttribute
     */
    public function setProductAttribute(ProductAttributeInterface $productAttribute = null)
    {
        $this->productAttribute = $productAttribute;
    }
}

