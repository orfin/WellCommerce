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
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePriceInterface;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitInterface;

/**
 * Class ProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductFactory extends EntityFactory
{
    public function create() : ProductInterface
    {
        $unit = $this->getDefaultUnit();
        $tax  = $this->getDefaultTax();

        /** @var  $product ProductInterface */
        $product = $this->init();
        $product->setCategories($this->createEmptyCollection());
        $product->setProductPhotos($this->createEmptyCollection());
        $product->setDistinctions($this->createEmptyCollection());
        $product->setVariants($this->createEmptyCollection());
        $product->setShops($this->getDefaultShops());
        $product->setEnabled(true);
        $product->setSellPrice($this->createDefaultDiscountablePrice());
        $product->setDimension(new Dimension());
        $product->setBuyPrice($this->createDefaultPrice());
        $product->setBuyPriceTax($tax);
        $product->setSellPriceTax($tax);
        $product->setUnit($unit);
        $product->setHierarchy(0);

        return $product;
    }
    
    private function getDefaultUnit() : UnitInterface
    {
        return $this->get('unit.repository')->findOneBy([]);
    }

    private function createDefaultDiscountablePrice() : DiscountablePriceInterface
    {
        return $this->get('discountable_price.factory')->create();
    }

    private function createDefaultPrice() : PriceInterface
    {
        return $this->get('price.factory')->create();
    }
}
