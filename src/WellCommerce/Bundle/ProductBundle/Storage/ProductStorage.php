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

namespace WellCommerce\Bundle\ProductBundle\Storage;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ProductStorage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStorage implements ProductStorageInterface
{
    /**
     * @var ProductInterface
     */
    protected $currentProduct;

    /**
     * {@inheritdoc}
     */
    public function setCurrentProduct(ProductInterface $product)
    {
        $this->currentProduct = $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProduct() : ProductInterface
    {
        return $this->currentProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentProduct() : bool
    {
        return $this->currentProduct instanceof ProductInterface;
    }
}
