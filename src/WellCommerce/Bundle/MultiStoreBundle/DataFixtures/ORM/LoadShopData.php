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

namespace WellCommerce\Bundle\ThemeBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Class LoadThemeData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadShopData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $theme   = $this->getReference('theme');
        $company = $this->getReference('company');

        $shop = new Shop();
        $shop->setName('WellCommerce');
        $shop->setCompany($company);
        $shop->setTheme($theme);
        $shop->setUrl('wellcommerce.dev');
        $manager->persist($shop);
        $manager->flush();

        $this->setReference('shop', $shop);
    }
}
