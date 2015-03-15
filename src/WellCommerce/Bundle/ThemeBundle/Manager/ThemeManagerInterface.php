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

namespace WellCommerce\Bundle\ThemeBundle\Manager;

use WellCommerce\Bundle\ThemeBundle\Entity\Theme;

/**
 * Interface ThemeManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeManagerInterface
{
    /**
     * Sets current theme object
     *
     * @param Theme $theme
     *
     * @return void
     */
    public function setCurrentTheme(Theme $theme);

    /**
     * Returns current theme object
     *
     * @return Theme
     */
    public function getCurrentTheme();

    /**
     * Returns path patterns to theme folder
     *
     * @return string
     */
    public function getThemePathPattern();

    /**
     * Returns full path to theme directory
     *
     * @return string
     */
    public function getCurrentThemeDirectory();

    /**
     * Returns path to themes directory
     *
     * @return string
     */
    public function getThemesDirectory();

    /**
     * Returns a full path for a given template
     *
     * @param string $name
     *
     * @return string
     */
    public function locateTemplate($name);
}
