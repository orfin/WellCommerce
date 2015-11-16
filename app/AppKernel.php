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

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class AppKernel
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
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
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Ivory\LuceneSearchBundle\IvoryLuceneSearchBundle(),
            // WellCommerce bundles
            new WellCommerce\Bundle\CoreBundle\WellCommerceCoreBundle(),
            new WellCommerce\Bundle\FormBundle\WellCommerceFormBundle(),
            new WellCommerce\Bundle\DataSetBundle\WellCommerceDataSetBundle(),
            new WellCommerce\Bundle\DataGridBundle\WellCommerceDataGridBundle(),
            new WellCommerce\Bundle\SmugglerBundle\WellCommerceSmugglerBundle(),
            new WellCommerce\Bundle\AdminBundle\WellCommerceAdminBundle(),
            new WellCommerce\Bundle\CommonBundle\WellCommerceCommonBundle(),
            new WellCommerce\Bundle\ReportBundle\WellCommerceReportBundle(),
            new WellCommerce\Bundle\CmsBundle\WellCommerceCmsBundle(),
            new WellCommerce\Bundle\TaxBundle\WellCommerceTaxBundle(),
            new WellCommerce\Bundle\MultiStoreBundle\WellCommerceMultiStoreBundle(),
            new WellCommerce\Bundle\ClientBundle\WellCommerceClientBundle(),
            new WellCommerce\Bundle\CatalogBundle\WellCommerceCatalogBundle(),
            new WellCommerce\Bundle\LayoutBundle\WellCommerceLayoutBundle(),
            new WellCommerce\Bundle\SalesBundle\WellCommerceSalesBundle(),
            new WellCommerce\Bundle\PromotionBundle\WellCommercePromotionBundle(),
            new WellCommerce\Bundle\SearchBundle\WellCommerceSearchBundle(),
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
