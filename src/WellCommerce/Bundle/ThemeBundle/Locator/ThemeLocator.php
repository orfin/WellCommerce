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

use Symfony\Component\Finder\Finder;

/**
 * Class ThemeLocator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeLocator
{
    /**
     * @var string
     */
    protected $themesDir;

    /**
     * @var array
     */
    protected $themeFolders = [];

    /**
     * ThemeLocator constructor.
     *
     * @param string $themesDir
     */
    public function __construct(string $themesDir)
    {
        $this->themesDir = $themesDir;
    }

    /**
     * Lists all themes available in web/themes directory
     *
     * @return array
     */
    public function getThemeFolders() : array
    {
        if (empty($this->themeFolders)) {
            $this->themeFolders = $this->scanThemesDirectory();
        }

        return $this->themeFolders;
    }

    protected function scanThemesDirectory() : array
    {
        $folders     = [];
        $finder      = new Finder();
        $directories = $finder->directories()->in($this->themesDir)->sortByName()->depth('== 1');

        foreach ($directories as $directory) {
            $name           = $directory->getRelativePath();
            $folders[$name] = $name;
        }

        return $folders;
    }
}
