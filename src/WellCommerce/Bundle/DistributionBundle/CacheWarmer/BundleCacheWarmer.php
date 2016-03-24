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

namespace WellCommerce\Bundle\DistributionBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use WellCommerce\Bundle\DistributionBundle\Loader\BundleLoader;

/**
 * Class BundleCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BundleCacheWarmer extends CacheWarmer
{
    /**
     * @var BundleLoader
     */
    protected $loader;

    /**
     * BundleCacheWarmer constructor.
     *
     * @param BundleLoader $loader
     */
    public function __construct(BundleLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $bundlesClasses = $this->loader->getManagedBundleClasses();
        if (count($bundlesClasses)) {
            $this->writeCacheFile($cacheDir . '/bundles.php', sprintf('<?php return %s;', var_export($bundlesClasses, true)));
        }
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * @return Boolean always true
     */
    public function isOptional()
    {
        return false;
    }
}
