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

namespace WellCommerce\Bundle\AdminBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use WellCommerce\Bundle\AdminBundle\Provider\AdminMenuProvider;

/**
 * Class AdminMenuCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuCacheWarmer extends CacheWarmer
{
    /**
     * @var AdminMenuProvider
     */
    protected $provider;

    /**
     * AdminMenuCacheWarmer constructor.
     *
     * @param AdminMenuProvider $provider
     */
    public function __construct(AdminMenuProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $this->writeCacheFile($cacheDir . '/admin_menu.php', sprintf('<?php return %s;', var_export($this->provider->getMenu(), true)));
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
