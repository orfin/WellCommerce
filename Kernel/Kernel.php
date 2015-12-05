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

namespace WellCommerce\Bundle\AppBundle\Kernel;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use WellCommerce\Bundle as Bundle;

/**
 * Class Kernel
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Kernel extends BaseKernel
{
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
            new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new \FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),
            new \Liip\ImagineBundle\LiipImagineBundle(),
            new \Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new \Ivory\LuceneSearchBundle\IvoryLuceneSearchBundle(),

            new Bundle\AdminBundle\WellCommerceAdminBundle(),
            new Bundle\AppBundle\WellCommerceAppBundle(),
            new Bundle\AttributeBundle\WellCommerceAttributeBundle(),
            new Bundle\AvailabilityBundle\WellCommerceAvailabilityBundle(),
            new Bundle\CartBundle\WellCommerceCartBundle(),
            new Bundle\CategoryBundle\WellCommerceCategoryBundle(),
            new Bundle\ContactBundle\WellCommerceContactBundle(),
            new Bundle\ClientBundle\WellCommerceClientBundle(),
            new Bundle\CoreBundle\WellCommerceCoreBundle(),
            new Bundle\CountryBundle\WellCommerceCountryBundle(),
            new Bundle\CouponBundle\WellCommerceCouponBundle(),
            new Bundle\CurrencyBundle\WellCommerceCurrencyBundle(),
            new Bundle\DelivererBundle\WellCommerceDelivererBundle(),
            new Bundle\DictionaryBundle\WellCommerceDictionaryBundle(),
            new Bundle\LocaleBundle\WellCommerceLocaleBundle(),
            new Bundle\CompanyBundle\WellCommerceCompanyBundle(),
            new Bundle\ShopBundle\WellCommerceShopBundle(),
            new Bundle\LayeredNavigationBundle\WellCommerceLayeredNavigationBundle(),
            new Bundle\LayoutBundle\WellCommerceLayoutBundle(),
            new Bundle\MediaBundle\WellCommerceMediaBundle(),
            new Bundle\NewsBundle\WellCommerceNewsBundle(),
            new Bundle\ThemeBundle\WellCommerceThemeBundle(),
            new Bundle\OrderBundle\WellCommerceOrderBundle(),
            new Bundle\PageBundle\WellCommercePageBundle(),
            new Bundle\PaymentBundle\WellCommercePaymentBundle(),
            new Bundle\ProducerBundle\WellCommerceProducerBundle(),
            new Bundle\ProductBundle\WellCommerceProductBundle(),
            new Bundle\ProductStatusBundle\WellCommerceProductStatusBundle(),
            new Bundle\ReportBundle\WellCommerceReportBundle(),
            new Bundle\ReviewBundle\WellCommerceReviewBundle(),
            new Bundle\RoutingBundle\WellCommerceRoutingBundle(),
            new Bundle\ShippingBundle\WellCommerceShippingBundle(),
            new Bundle\SmugglerBundle\WellCommerceSmugglerBundle(),
            new Bundle\TaxBundle\WellCommerceTaxBundle(),
            new Bundle\UnitBundle\WellCommerceUnitBundle(),
            new Bundle\WishlistBundle\WellCommerceWishlistBundle()

        ];

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
