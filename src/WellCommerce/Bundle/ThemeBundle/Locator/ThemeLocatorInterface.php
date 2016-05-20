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

/**
 * Interface ThemeLocatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeLocatorInterface
{
    /**
     * Returns path patterns to theme folder
     *
     * @return string
     */
    public function getThemePathPattern() : string;
    
    /**
     * Returns current theme folder
     *
     * @return string
     */
    public function getCurrentThemeFolder() : string;
    
    /**
     * Returns path to themes directory
     *
     * @return string
     */
    public function getThemesDirectory() : string;
    
    /**
     * Returns an array of all theme folders
     *
     * @return array
     */
    public function getThemeFolders() : array;
    
    /**
     * Returns a full path for a given template
     *
     * @param string $name
     *
     * @return string
     */
    public function locateTemplate(string $name) : string;
}
