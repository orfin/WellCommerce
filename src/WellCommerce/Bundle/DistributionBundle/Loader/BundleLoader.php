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

use Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle;
use Cache\AdapterBundle\CacheAdapterBundle;
use Doctrine\Bundle\CoreBundle\CoreBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use EmanueleMinotto\TwigCacheBundle\TwigCacheBundle;
use FOS\JsRoutingBundle\FOSJsRoutingBundle;
use Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle;
use Liip\ImagineBundle\LiipImagineBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\DistributionBundle\Locator\BundleLocator;

/**
 * Class BundleLoader
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class BundleLoader
{
    const CACHE_FILENAME = 'bundles.php';
    
    /**
     * @var KernelInterface
     */
    private $kernel;
    
    /**
     * BundleLoader constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    
    public function loadBundles() : array
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
    
    public function getManagedBundleClasses() : array
    {
        $bundles = $this->getCoreBundlesClasses();
        $locator = $this->getLocator();
        $bundles = array_merge($bundles, $locator->locateBundleClasses());
        
        return $bundles;
    }
    
    private function getCoreBundlesClasses() : array
    {
        $bundles = [
            FrameworkBundle::class,
            SecurityBundle::class,
            TwigBundle::class,
            MonologBundle::class,
            SwiftmailerBundle::class,
            DoctrineBundle::class,
            DoctrineCacheBundle::class,
            DoctrineMigrationsBundle::class,
            DoctrineFixturesBundle::class,
            SensioFrameworkExtraBundle::class,
            FOSJsRoutingBundle::class,
            BazingaJsTranslationBundle::class,
            LiipImagineBundle::class,
            DoctrineBehaviorsBundle::class,
            CacheAdapterBundle::class,
            TwigCacheBundle::class
        ];
        
        if (in_array($this->kernel->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = WebProfilerBundle::class;
            $bundles[] = SensioGeneratorBundle::class;
        }
        
        if (in_array($this->kernel->getEnvironment(), ['prod'])) {
            $bundles[] = WebProfilerBundle::class;
        }
        
        return $bundles;
    }
    
    private function getLocator() : BundleLocator
    {
        return new BundleLocator($this->kernel);
    }
}
