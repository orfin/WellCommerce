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

namespace WellCommerce\CatalogBundle\Helper;

use Doctrine\Common\Collections\Collection;

/**
 * Interface ProductAttributeHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductAttributeHelperInterface
{
    /**
     * Returns an array containing all attributes and its values
     *
     * @param Collection $productAttributeCollection
     *
     * @return array
     */
    public function getAttributeGroups(Collection $productAttributeCollection);

    /**
     * Returns an array of all product attributes
     *
     * @param Collection $productAttributeCollection
     *
     * @return array
     */
    public function getAttributes(Collection $productAttributeCollection);
}
