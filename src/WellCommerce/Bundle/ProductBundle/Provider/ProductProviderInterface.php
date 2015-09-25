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

namespace WellCommerce\Bundle\ProductBundle\Provider;

use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface ProductProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductProviderInterface extends ProviderInterface
{
    /**
     * Sets currently viewed product
     *
     * @param ProductInterface $product
     */
    public function setCurrentProduct(ProductInterface $product);

    /**
     * Returns an instance of currently viewed product
     *
     * @return ProductInterface
     */
    public function getCurrentProduct();

    /**
     * Returns a dataset of products recommended for category
     *
     * @param CategoryInterface $category
     *
     * @return array
     */
    public function getProductRecommendationsForCategory(CategoryInterface $category);

    /**
     * Checks whether provider contains product object
     *
     * @return bool
     */
    public function hasCurrentProduct();
}
