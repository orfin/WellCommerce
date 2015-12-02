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

            new \WellCommerce\Bundle\AppBundle\WellCommerceAppBundle(),
            new \WellCommerce\Bundle\AttributeBundle\WellCommerceAttributeBundle(),
            new \WellCommerce\Bundle\ClientBundle\WellCommerceClientBundle(),
            new \WellCommerce\Bundle\CoreBundle\WellCommerceCoreBundle(),
            new \WellCommerce\Bundle\UserBundle\WellCommerceUserBundle(),
            new \WellCommerce\Bundle\CurrencyBundle\WellCommerceCurrencyBundle(),
            new \WellCommerce\Bundle\LocaleBundle\WellCommerceLocaleBundle(),
            new \WellCommerce\Bundle\CompanyBundle\WellCommerceCompanyBundle(),
            new \WellCommerce\Bundle\ShopBundle\WellCommerceShopBundle(),
            new \WellCommerce\Bundle\LayoutBundle\WellCommerceLayoutBundle(),
            new \WellCommerce\Bundle\ThemeBundle\WellCommerceThemeBundle(),
            new \WellCommerce\Bundle\ProducerBundle\WellCommerceProducerBundle(),
            new \WellCommerce\Bundle\ProductBundle\WellCommerceProductBundle(),
            new \WellCommerce\Bundle\ProductStatusBundle\WellCommerceProductStatusBundle(),
            new \WellCommerce\Bundle\ShippingBundle\WellCommerceShippingBundle(),
            new \WellCommerce\Bundle\UnitBundle\WellCommerceUnitBundle()

        ];

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
