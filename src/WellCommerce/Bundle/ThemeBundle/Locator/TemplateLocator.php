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

namespace WellCommerce\Bundle\ThemeBundle\Locator;

use Symfony\Bundle\FrameworkBundle\Templating\Loader\TemplateLocator as BaseTemplateLocator;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * Class TemplateLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * Created on base of the LiipAppBundle <https://github.com/liip/LiipAppBundle>
 *
 * Special thanks goes to its authors and contributors
 */
class TemplateLocator extends BaseTemplateLocator
{
    /**
     * @return FileLocatorInterface
     */
    public function getLocator()
    {
        return $this->locator;
    }
    
    protected function getCacheKey($template)
    {
        return $template->getLogicalName();
    }
    
    /**
     * Returns a full path for a given file.
     *
     * @param string|TemplateReferenceInterface $template
     * @param null                              $currentPath
     * @param bool                              $first
     *
     * @return string The full path for the file
     */
    public function locate($template, $currentPath = null, $first = true)
    {
        if (!$template instanceof TemplateReferenceInterface) {
            throw new \InvalidArgumentException("The template must be an instance of TemplateReferenceInterface.");
        }
        
        $key = $this->getCacheKey($template);
        
        if (!isset($this->cache[$key])) {
            try {
                $this->cache[$key] = $this->locator->locate($template->getPath(), $currentPath);
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException(sprintf(
                    'Unable to find template "%s" in "%s".',
                    $template,
                    $e->getMessage()
                ));
            }
        }
        
        return $this->cache[$key];
    }
}
