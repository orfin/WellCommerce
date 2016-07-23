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

namespace WellCommerce\Bundle\DistributionBundle\Locator;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\AppBundle\WellCommerceAppBundle;
use Wingu\OctopusCore\Reflection\ReflectionFile;

/**
 * Class BundleLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class BundleLocator
{
    /**
     * @var string
     */
    private $rootDir;
    
    /**
     * BundleLocator constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->rootDir = $kernel->getRootDir() . '/../src';
    }
    
    public function locateBundleClasses() : array
    {
        $finder = new Finder();
        $finder->in($this->rootDir)->name('*Bundle.php')->notName('WellCommerceAppBundle.php')->depth(3);
        $bundles = [WellCommerceAppBundle::class];
        
        foreach ($finder->files() as $file) {
            $bundle = $this->getBundleClass($file);
            if (null !== $bundle) {
                $bundles[] = $bundle;
            }
        }
        
        $this->sortBundles($bundles);
        
        return $bundles;
    }
    
    private function sortBundles(array &$bundles)
    {
        uasort($bundles, function (string $class) {
            return $this->getBundleVendor($class) === 'WellCommerce';
        });
    }
    
    private function getBundleVendor(string $class)
    {
        list($vendor,) = explode('\\', ltrim($class, '\\'));
        
        return $vendor;
    }
    
    /**
     * Returns FQCN for file
     *
     * @param SplFileInfo $fileInfo
     *
     * @return string|null
     */
    private function getBundleClass(SplFileInfo $fileInfo)
    {
        $reflection = new ReflectionFile($fileInfo->getRealPath());
        $baseName   = $fileInfo->getBasename('.php');
        
        foreach ($reflection->getNamespaces() as $namespace) {
            return $namespace . '\\' . $baseName;
        }
        
        return null;
    }
}
