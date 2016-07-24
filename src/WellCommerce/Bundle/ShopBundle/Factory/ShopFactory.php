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

use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroupInterface;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShopBundle\Entity\Shop;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Class ShopFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFactory extends AbstractEntityFactory
{
    public function create() : ShopInterface
    {
        $shop = new Shop();
        $shop->setName('');
        $shop->setUrl('');
        $shop->setMailerConfiguration(new MailerConfiguration());
        $shop->setCompany(null);
        $shop->setTheme(null);
        $shop->setDefaultCurrency('');
        $shop->setDefaultCountry('');
        $shop->setClientGroup(null);
        
        return $shop;
    }
}
