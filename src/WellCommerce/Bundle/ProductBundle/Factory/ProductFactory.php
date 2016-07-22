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

namespace WellCommerce\Bundle\ProductBundle\Factory;

use WellCommerce\Bundle\AppBundle\Entity\Dimension;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePriceInterface;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitInterface;

/**
 * Class ProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductFactory extends AbstractEntityFactory
{
    public function create() : ProductInterface
    {
        $product = new Product();
        $product->setCategories($this->createEmptyCollection());
        $product->setProductPhotos($this->createEmptyCollection());
        $product->setDistinctions($this->createEmptyCollection());
        $product->setVariants($this->createEmptyCollection());
        $product->setShops($this->createEmptyCollection());
        $product->setEnabled(true);
        $product->setSellPrice(new DiscountablePrice());
        $product->setDimension(new Dimension());
        $product->setBuyPrice(new Price());
        $product->setBuyPriceTax(null);
        $product->setSellPriceTax(null);
        $product->setUnit(null);
        $product->setHierarchy(0);

        return $product;
    }
}
