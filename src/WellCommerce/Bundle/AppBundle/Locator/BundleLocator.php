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
    protected $rootDir;

    /**
     * BundleLocator constructor.
     *
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getBundles()
    {
        $bundles = [];
        $finder  = new Finder();
        $finder->in($this->rootDir)->name('*Bundle.php')->notName('WellCommerceAppBundle*')->depth(3);

        foreach ($finder->files() as $file) {
            $bundle = $this->getBundleClass($file);
            if (null !== $bundle) {
                $bundles[] = $bundle;
            }
        }

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
