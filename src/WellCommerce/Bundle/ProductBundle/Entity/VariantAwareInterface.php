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

/**
 * Interface VariantAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface VariantAwareInterface
{
    /**
     * @param VariantInterface $variant
     */
    public function setVariant(VariantInterface $variant);
    
    /**
     * @return VariantInterface|null
     */
    public function getVariant();
    
    /**
     * @return bool
     */
    public function hasVariant() : bool;
}
