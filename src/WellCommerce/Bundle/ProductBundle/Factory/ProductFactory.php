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
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\ProductBundle\Entity\Product;

class ProductFactory extends AbstractFactory
{
    public function create()
    {
        $product = new Product();
        $product->setCategories(new ArrayCollection());

        $this->categories    = new ArrayCollection();
        $this->productPhotos = new ArrayCollection();
        $this->statuses      = new ArrayCollection();
        $this->attributes    = new ArrayCollection();
        $this->shops         = new ArrayCollection();
        $this->dimension     = new Dimension();
        $this->sellPrice     = new Price();
        $this->buyPrice      = new Price();


        return $product;
    }
}
