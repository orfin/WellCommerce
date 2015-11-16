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

namespace WellCommerce\Bundle\CatalogBundle\Context\Front;

use WellCommerce\Bundle\CatalogBundle\Entity\ProductInterface;

/**
 * Class ProductContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductContext implements ProductContextInterface
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
    public function getCurrentProduct()
    {
        return $this->currentProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentProduct()
    {
        return $this->currentProduct instanceof ProductInterface;
    }

}
