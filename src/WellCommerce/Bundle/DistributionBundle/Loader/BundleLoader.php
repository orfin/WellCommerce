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

namespace WellCommerce\Bundle\DistributionBundle\Loader;

use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\DistributionBundle\Locator\BundleLocator;

/**
 * Class BundleLoader
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BundleLoader
{
    const CACHE_FILENAME = 'bundles.php';

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * BundleLoader constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface
     */
    public function loadBundles()
    {
        $bundles = [];

        if (is_file($cache = $this->kernel->getCacheDir() . '/' . self::CACHE_FILENAME)) {
            $bundleClasses = require $cache;
        } else {
            $bundleClasses = $this->getManagedBundleClasses();
        }

        foreach ($bundleClasses as $bundleClass) {
            $bundles[] = new $bundleClass;
        }

        return $bundles;
    }

    /**
     * @return array
     */
    public function getManagedBundleClasses()
    {
        $bundles = $this->getCoreBundlesClasses();
        $locator = $this->getLocator();
        $bundles = array_merge($bundles, $locator->locateBundleClasses());

        return $bundles;
    }

    /**
     * @return array
     */
    protected function getCoreBundlesClasses()
    {
        $bundles = [
            \Symfony\Bundle\FrameworkBundle\FrameworkBundle::class,
            \Symfony\Bundle\SecurityBundle\SecurityBundle::class,
            \Symfony\Bundle\TwigBundle\TwigBundle::class,
            \Symfony\Bundle\MonologBundle\MonologBundle::class,
            \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle::class,
            \Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class,
            \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class,
            \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class,
            \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class,
            \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class,
            \FOS\JsRoutingBundle\FOSJsRoutingBundle::class,
            \Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle::class,
            \Liip\ImagineBundle\LiipImagineBundle::class,
            \Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle::class,
            \Cache\AdapterBundle\CacheAdapterBundle::class,
            \WellCommerce\Bundle\AppBundle\WellCommerceAppBundle::class,
        ];

        if (in_array($this->kernel->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class;
            $bundles[] = \Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle::class;
        }

        return $bundles;
    }

    /**
     * @return BundleLocator
     */
    protected function getLocator()
    {
        return new BundleLocator($this->kernel);
    }
}
