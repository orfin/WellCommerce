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

namespace WellCommerce\Bundle\CommonBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CoreBundle\Entity\MailerConfiguration;

/**
 * Class LoadShopData
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
         * @var $theme       \WellCommerce\Bundle\LayoutBundle\Entity\ThemeInterface
         * @var $company     \WellCommerce\Bundle\CommonBundle\Entity\CompanyInterface
         * @var $orderStatus \WellCommerce\Bundle\SalesBundle\Entity\OrderStatusInterface
         */
        $theme    = $this->getReference('theme');
        $company  = $this->getReference('company');
        $currency = $this->randomizeSamples('currency', LoadCurrencyData::$samples);

        $shop = $this->container->get('shop.factory')->create();
        $shop->setName('WellCommerce');
        $shop->setCompany($company);
        $shop->setTheme($theme);
        $shop->setUrl($this->container->getParameter('fallback_hostname'));
        $shop->setDefaultCountry('US');
        $shop->setDefaultCurrency($currency->getCode());

        $mailerConfiguration = new MailerConfiguration();
        $mailerConfiguration->setFrom('');
        $mailerConfiguration->setHost('');
        $mailerConfiguration->setPort('');
        $mailerConfiguration->setUser('');
        $mailerConfiguration->setPass('');

        $shop->setMailerConfiguration($mailerConfiguration);

        $manager->persist($shop);
        $manager->flush();

        $this->setReference('shop', $shop);
    }
}
