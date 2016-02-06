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

use BetterReflection\Reflector\ClassReflector;
use BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use WellCommerce\Bundle\AppBundle\Kernel\WellCommerceKernelInterface;

/**
 * Class BundleLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BundleLocator implements BundleLocatorInterface
{
    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var array
     */
    protected $bundles;

    /**
     * BundleLocator constructor.
     *
     * @param WellCommerceKernelInterface $kernel
     */
    public function __construct(WellCommerceKernelInterface $kernel)
    {
        $this->rootDir = $kernel->getSourceDirectory();
        $this->bundles = $kernel->getCoreBundles();
    }

    /**
     * {@inheritdoc}
     */
    public function getBundles()
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

        $bundles = array_merge($this->bundles, $bundles);

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
        $reflector         = new ClassReflector(new SingleFileSourceLocator($fileInfo->getRealpath()));
        $reflectionClasses = $reflector->getAllClasses();

        foreach ($reflectionClasses as $reflectionClass) {
            return $reflectionClass->getName();
        }

        return null;
    }
}
