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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AppBundle\Entity\Dimension;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePriceInterface;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitInterface;

/**
 * Class ProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ProductInterface::class;

    /**
     * @return ProductInterface
     */
    public function create() : ProductInterface
    {
        $unit = $this->getDefaultUnit();
        $tax  = $this->getDefaultTax();

        /** @var  $product ProductInterface */
        $product = $this->init();
        $product->setCategories(new ArrayCollection());
        $product->setProductPhotos(new ArrayCollection());
        $product->setStatuses(new ArrayCollection());
        $product->setVariants(new ArrayCollection());
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
