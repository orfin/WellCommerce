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

namespace WellCommerce\Bundle\ThemeBundle\CacheWarmer;

use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplatePathsCacheWarmer as BaseTemplatePathsCacheWarmer;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\Config\FileLocatorInterface;

/**
 * Class TemplatePathsCacheWarmer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipAppBundle <https://github.com/liip/LiipAppBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class TemplatePathsCacheWarmer extends BaseTemplatePathsCacheWarmer
{
    /**
     * @var \WellCommerce\Bundle\ThemeBundle\Locator\TemplateLocator
     */
    protected $locator;
    
    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $locator      = $this->locator->getLocator();
        $allTemplates = $this->finder->findAllTemplates();
        $templates    = [];
        foreach ($allTemplates as $template) {
            $this->locateTemplate($locator, $template, $templates);
        }
        
        $this->writeCacheFile($cacheDir . '/templates.php', sprintf('<?php return %s;', var_export($templates, true)));
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
    
    /**
     * Locates and appends template to an array
     *
     * @param FileLocatorInterface $locator
     * @param TemplateReference    $template
     * @param array                $templates
     */
    protected function locateTemplate(FileLocatorInterface $locator, TemplateReference $template, array &$templates)
    {
        $templates[$template->getLogicalName()] = $locator->locate($template->getPath());
    }
}
