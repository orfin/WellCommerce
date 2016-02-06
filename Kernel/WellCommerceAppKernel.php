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
use Symfony\Component\HttpKernel\Kernel;
use WellCommerce\Bundle\DistributionBundle\Locator\BundleLocator;

/**
 * Class WellCommerceAppKernel
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WellCommerceAppKernel extends Kernel implements WellCommerceKernelInterface
{
    public function registerBundles()
    {
        $bundles = [];

        foreach ($this->getApplicationBundles() as $bundle) {
            $bundles[] = new $bundle;
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceDirectory()
    {
        return $this->rootDir . '/../src';
    }

    /**
     * @return array
     */
    private function getApplicationBundles()
    {
        if (is_file($cache = $this->getCacheDir() . '/bundles.php')) {
            $bundles = require $cache;
        } else {
            $locator = new BundleLocator($this);
            $bundles = $locator->getBundles();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function getCoreBundles()
    {
        $bundles = [
            \Symfony\Bundle\FrameworkBundle\FrameworkBundle::class,
            \Symfony\Bundle\SecurityBundle\SecurityBundle::class,
            \Symfony\Bundle\TwigBundle\TwigBundle::class,
            \Symfony\Bundle\MonologBundle\MonologBundle::class,
            \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle::class,
            \Symfony\Bundle\AsseticBundle\AsseticBundle::class,
            \Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class,
            \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class,
            \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class,
            \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class,
            \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class,
            \FOS\JsRoutingBundle\FOSJsRoutingBundle::class,
            \Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle::class,
            \Liip\ImagineBundle\LiipImagineBundle::class,
            \Ivory\LuceneSearchBundle\IvoryLuceneSearchBundle::class,
            \Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle::class,
            \WellCommerce\Bundle\AppBundle\WellCommerceAppBundle::class,
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class;
            $bundles[] = \Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle::class;
        }

        return $bundles;
    }
}
