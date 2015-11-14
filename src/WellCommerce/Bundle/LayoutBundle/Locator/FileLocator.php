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

namespace WellCommerce\Bundle\LayoutBundle\Locator;

use Symfony\Component\Config\FileLocator as BaseFileLocator;
use WellCommerce\Bundle\LayoutBundle\Manager\ThemeManagerInterface;

/**
 * Class FileLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileLocator extends BaseFileLocator
{
    /**
     * @var ThemeManagerInterface
     */
    protected $themeManager;

    /**
     * Constructor
     *
     * @param ThemeManagerInterface $themeManager
     */
    public function __construct(ThemeManagerInterface $themeManager, $path = null)
    {
        $this->themeManager = $themeManager;
        $this->setPaths($path);
    }

    protected function setPaths($path)
    {
        $paths       = [];
        $paths[]     = $path;
        $this->paths = $paths;
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
            return $this->themeManager->locateTemplate($name);
        }

        return parent::locate($name, $dir, $first);
    }
}
