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

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),
            new WellCommerce\Bundle\FormBundle\WellCommerceFormBundle(),
            // WellCommerce bundles
            new WellCommerce\Bundle\CoreBundle\WellCommerceCoreBundle(),
            new WellCommerce\Bundle\AdminBundle\WellCommerceAdminBundle(),
            new WellCommerce\Bundle\WebBundle\WellCommerceWebBundle(),
            new WellCommerce\Bundle\NewsBundle\WellCommerceNewsBundle(),
            new WellCommerce\Bundle\MediaBundle\WellCommerceMediaBundle(),
            new WellCommerce\Bundle\CurrencyBundle\WellCommerceCurrencyBundle(),
            new WellCommerce\Bundle\AvailabilityBundle\WellCommerceAvailabilityBundle(),
            new WellCommerce\Bundle\DelivererBundle\WellCommerceDelivererBundle(),
            new WellCommerce\Bundle\ProducerBundle\WellCommerceProducerBundle(),
            new WellCommerce\Bundle\CategoryBundle\WellCommerceCategoryBundle(),
            new WellCommerce\Bundle\CountryBundle\WellCommerceCountryBundle(),
            new WellCommerce\Bundle\TaxBundle\WellCommerceTaxBundle(),
            new WellCommerce\Bundle\UnitBundle\WellCommerceUnitBundle(),
            new WellCommerce\Bundle\CompanyBundle\WellCommerceCompanyBundle(),
            new WellCommerce\Bundle\ContactBundle\WellCommerceContactBundle(),
            new WellCommerce\Bundle\ClientBundle\WellCommerceClientBundle(),
            new WellCommerce\Bundle\LocaleBundle\WellCommerceLocaleBundle(),
            new WellCommerce\Bundle\ShopBundle\WellCommerceShopBundle(),
            new WellCommerce\Bundle\UserBundle\WellCommerceUserBundle(),
            new WellCommerce\Bundle\ProductBundle\WellCommerceProductBundle(),
            new WellCommerce\Bundle\DashboardBundle\WellCommerceDashboardBundle(),
            new WellCommerce\Bundle\PaymentBundle\WellCommercePaymentBundle(),
            new WellCommerce\Bundle\AttributeBundle\WellCommerceAttributeBundle(),
            new WellCommerce\Bundle\ThemeBundle\WellCommerceThemeBundle(),
            new WellCommerce\Bundle\LayoutBundle\WellCommerceLayoutBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
