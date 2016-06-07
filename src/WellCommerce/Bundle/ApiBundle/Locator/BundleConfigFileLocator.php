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

namespace WellCommerce\Bundle\ApiBundle\Locator;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class MappingFileLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class MappingFileLocator implements MappingFileLocatorInterface
{
    private $kernel;
    
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    private function resolvePath(string $path) : string
    {
        $resourcePathExploded = explode('/', $path);
        $resourcePathRoot     = array_shift($resourcePathExploded);
        
        if (strpos($resourcePathRoot, '@') === 0) {
            $mappingFileBundle = ltrim($resourcePathRoot, '@');
            $bundle            = $this->kernel->getBundle($mappingFileBundle);
            
            if ($bundle instanceof BundleInterface) {
                $resourcePathRoot = $bundle->getPath();
            }
        }
        
        array_unshift($resourcePathExploded, $resourcePathRoot);
        
        return implode('/', $resourcePathExploded);
    }
}
