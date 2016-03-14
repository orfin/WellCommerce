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


trait VariantAwareTrait
{
    /**
     * @var null|VariantInterface
     */
    protected $variant;

    /**
     * @return null|VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * @param null|VariantInterface $variant
     */
    public function setVariant(VariantInterface $variant = null)
    {
        $this->variant = $variant;
    }
}

