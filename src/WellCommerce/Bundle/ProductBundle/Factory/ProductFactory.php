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
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ProductInterface::class;

    /**
     * @return \WellCommerce\Bundle\ProductBundle\Entity\ProductInterface
     */
    public function create()
    {
        /** @var  $product ProductInterface */
        $product = $this->init();
        $product->setCategories(new ArrayCollection());
        $product->setProductPhotos(new ArrayCollection());
        $product->setStatuses(new ArrayCollection());
        $product->setAttributes(new ArrayCollection());
        $product->setShops(new ArrayCollection());
        $product->setEnabled(true);
        $product->setStock(0);
        $product->setWeight(0);
        $product->setPackageSize(1);
        $product->setSellPrice(new DiscountablePrice());
        $product->setDimension(new Dimension());
        $product->setBuyPrice(new Price());

        return $product;
    }
}
