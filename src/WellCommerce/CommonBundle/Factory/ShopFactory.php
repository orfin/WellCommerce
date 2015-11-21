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

namespace WellCommerce\CommonBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\CommonBundle\Entity\Shop;
use WellCommerce\CoreBundle\Entity\MailerConfiguration;
use WellCommerce\CoreBundle\Factory\AbstractFactory;

/**
 * Class ShopFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CommonBundle\Entity\ShopInterface
     */
    public function create()
    {
        $shop = new Shop();
        $shop->setProducts(new ArrayCollection());
        $shop->setCategories(new ArrayCollection());
        $shop->setPages(new ArrayCollection());
        $shop->setProducers(new ArrayCollection());
        $shop->setMailerConfiguration(new MailerConfiguration());

        return $shop;
    }
}
