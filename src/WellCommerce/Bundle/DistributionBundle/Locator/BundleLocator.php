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
use Wingu\OctopusCore\Reflection\ReflectionFile;

/**
 * Class BundleLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BundleLocator
{
    /**
     * @var string
     */
    protected $rootDir;

    /**
     * BundleLocator constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->rootDir = $kernel->getRootDir() . '/../src';
    }

    /**
     * @return array
     */
    public function locateBundleClasses()
    {
        $finder = new Finder();
        $finder->in($this->rootDir)->name('*Bundle.php')->notName('WellCommerceAppBundle*')->depth(3);
        $bundles = [];

        foreach ($finder->files() as $file) {
            $bundle = $this->getBundleClass($file);
            if (null !== $bundle) {
                $bundles[] = $bundle;
            }
        }

        natsort($bundles);

        return $bundles;
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
