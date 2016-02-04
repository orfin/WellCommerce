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

namespace WellCommerce\Bundle\AppBundle\Locator;

use BetterReflection\Reflector\ClassReflector;
use BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
    protected $searchPath;

    /**
     * @var array
     */
    protected $bundles = [];

    /**
     * BundleLocator constructor.
     *
     * @param string $searchPath
     */
    public function __construct($searchPath)
    {
        $this->searchPath = $searchPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getBundles()
    {
        $bundles = [];
        $finder  = $this->getFinder();

        foreach ($finder as $file) {
            if (null !== $bundle = $this->getBundleClass($file)) {
                $bundles[] = $bundle;
            }
        }

        return $bundles;
    }

    /**
     * @return Finder
     */
    private function getFinder()
    {
        $finder = new Finder();
        $finder->files()->in($this->searchPath)->name('*Bundle.php')->notName('WellCommerceAppBundle*')->depth(3);

        return $finder;
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
