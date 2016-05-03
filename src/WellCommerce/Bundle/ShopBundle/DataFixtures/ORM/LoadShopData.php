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

namespace WellCommerce\Bundle\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\CurrencyBundle\DataFixtures\ORM\LoadCurrencyData;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;

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
        if (!$this->isEnabled()) {
            return;
        }

        /**
         * @var $theme       \WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface
         * @var $company     \WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface
         * @var $orderStatus \WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface
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
        $shop->setClientGroup($this->getReference('client_group'));

        $mailerConfiguration = new MailerConfiguration();
        $mailerConfiguration->setFrom($this->container->getParameter('mailer_from'));
        $mailerConfiguration->setHost($this->container->getParameter('mailer_host'));
        $mailerConfiguration->setPort($this->container->getParameter('mailer_port'));
        $mailerConfiguration->setUser($this->container->getParameter('mailer_user'));
        $mailerConfiguration->setPass($this->container->getParameter('mailer_password'));

        $shop->setMailerConfiguration($mailerConfiguration);

        $manager->persist($shop);
        $manager->flush();

        $this->get('shop.storage')->setCurrentShop($shop);
        $this->setReference('shop', $shop);
    }
}
