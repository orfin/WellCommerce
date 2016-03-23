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

use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface ProductHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductHelperInterface
{
    /**
     * Returns the default product's template variables
     *
     * @param ProductInterface $product
     *
     * @return array
     */
    public function getProductDefaultTemplateData(ProductInterface $product) : array;

    /**
     * Returns a dataset of products recommended for category
     *
     * @param CategoryInterface $category
     *
     * @return array
     */
    public function getProductRecommendationsForCategory(CategoryInterface $category) : array;
}
