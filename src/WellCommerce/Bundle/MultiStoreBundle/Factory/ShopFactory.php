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

namespace WellCommerce\Bundle\MultiStoreBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Class ShopFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface
     */
    public function create()
    {
        $shop = new Shop();
        $shop->setProducts(new ArrayCollection());
        $shop->setCategories(new ArrayCollection());
        $shop->setPages(new ArrayCollection());
        $shop->setProducers(new ArrayCollection());

        return $shop;
    }
}
