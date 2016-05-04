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
 * Class VariantAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait VariantAwareTrait
{
    /**
     * @var VariantInterface
     */
    protected $variant;

    public function getVariant() : VariantInterface
    {
        return $this->variant;
    }

    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;
    }

    public function hasVariant() : bool
    {
        return $this->variant instanceof VariantInterface;
    }
}

