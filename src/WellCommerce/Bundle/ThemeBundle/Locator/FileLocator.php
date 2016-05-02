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

use Symfony\Component\Config\FileLocator as BaseFileLocator;

/**
 * Class FileLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileLocator extends BaseFileLocator
{
    /**
     * @var ThemeLocatorInterface
     */
    protected $themeLocator;
    
    /**
     * FileLocator constructor.
     *
     * @param ThemeLocatorInterface $themeLocator
     * @param array                 $paths
     */
    public function __construct(ThemeLocatorInterface $themeLocator, array $paths = [])
    {
        parent::__construct($paths);
        $this->themeLocator = $themeLocator;
    }
    
    /**
     * Returns a full path for a given template
     *
     * @param mixed       $name
     * @param string|null $dir
     * @param bool        $first
     *
     * @return array|string
     */
    public function locate($name, $dir = null, $first = true)
    {
        if ('@' === $name[0]) {
            return $this->themeLocator->locateTemplate($name);
        }
        
        return parent::locate($name, $dir, $first);
    }
}
