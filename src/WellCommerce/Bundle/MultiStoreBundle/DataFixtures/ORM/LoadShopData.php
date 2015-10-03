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
        /**
         * @var $theme       \WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface
         * @var $company     \WellCommerce\Bundle\MultiStoreBundle\Entity\CompanyInterface
         * @var $orderStatus \WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface
         */
        $theme       = $this->getReference('theme');
        $company     = $this->getReference('company');
        $orderStatus = $this->getReference('default_order_status');

        $shop = $this->container->get('shop.factory')->create();
        $shop->setName('WellCommerce');
        $shop->setCompany($company);
        $shop->setTheme($theme);
        $shop->setUrl($this->container->getParameter('fallback_hostname'));
        $shop->setDefaultCountry('US');
        $manager->persist($shop);
        $manager->flush();

        $this->setReference('shop', $shop);
    }
}
