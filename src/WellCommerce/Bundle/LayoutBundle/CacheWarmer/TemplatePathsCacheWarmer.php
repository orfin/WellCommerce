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

namespace WellCommerce\Bundle\LayoutBundle\CacheWarmer;

use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface;
use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplatePathsCacheWarmer as BaseTemplatePathsCacheWarmer;
use Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator;

/**
 * Class TemplatePathsCacheWarmer
 *
 * @package WellCommerce\Bundle\LayoutBundle\CacheWarmer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipThemeBundle <https://github.com/liip/LiipThemeBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class TemplatePathsCacheWarmer extends BaseTemplatePathsCacheWarmer
{
    /**
     * Constructor
     *
     * @param TemplateFinderInterface $finder
     * @param TemplateLocator         $locator
     */
    public function __construct(TemplateFinderInterface $finder, TemplateLocator $locator)
    {
        parent::__construct($finder, $locator);
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        if (empty($this->activeTheme)) {
            return;
        }

        $locator = $this->locator->getLocator();

        $allTemplates = $this->finder->findAllTemplates();

        $templates = array();
        foreach ($this->activeTheme->getThemes() as $theme) {
            $this->activeTheme->setName($theme);
            foreach ($allTemplates as $template) {
                $templates[$template->getLogicalName() . '|' . $theme] = $locator->locate($template->getPath());
            }
        }

        $this->writeCacheFile($cacheDir . '/templates.php', sprintf('<?php return %s;', var_export($templates, true)));
    }

    /**
     * Checks whether cache warmer is optional
     *
     * @return bool
     */
    public function isOptional()
    {
        return true;
    }
}