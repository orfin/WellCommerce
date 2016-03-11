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

namespace WellCommerce\Bundle\ShopBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class ShopFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ShopInterface::class;

    /**
     * @return ShopInterface
     */
    public function create()
    {
        /** @var  $shop ShopInterface */
        $shop = $this->init();
        $shop->setProducts(new ArrayCollection());
        $shop->setCategories(new ArrayCollection());
        $shop->setPages(new ArrayCollection());
        $shop->setProducers(new ArrayCollection());
        $shop->setMailerConfiguration(new MailerConfiguration());

        return $shop;
    }
}
