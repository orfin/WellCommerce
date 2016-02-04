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

namespace WellCommerce\Bundle\AppBundle\CacheWarmer;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use WellCommerce\Bundle\AppBundle\Locator\BundleLocatorInterface;

/**
 * Class BundleCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BundleCacheWarmer extends CacheWarmer
{
    /**
     * @var BundleLocatorInterface
     */
    protected $locator;

    /**
     * BundleCacheWarmer constructor.
     *
     * @param BundleLocatorInterface $locator
     */
    public function __construct(BundleLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $bundles = $this->locator->getBundles();
        $content = sprintf('<?php return %s;', var_export($bundles, true));

        $this->writeCacheFile($cacheDir . '/bundles.php', $content);
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
