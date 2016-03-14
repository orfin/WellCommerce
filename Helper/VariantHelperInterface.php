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

use Doctrine\Common\Collections\Collection;

/**
 * Interface VariantHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface VariantHelperInterface
{
    /**
     * Returns an array containing all attributes and its values
     *
     * @param Collection $collection
     *
     * @return array
     */
    public function getAttributeGroups(Collection $collection) : array;

    /**
     * Returns an array of all product attributes
     *
     * @param Collection $productAttributeCollection
     *
     * @return array
     */
    public function getAttributes(Collection $collection) : array;
}
