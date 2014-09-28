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
 * @package WellCommerce\Bundle\ThemeBundle\Manager
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
     * @return array
     */
    public function getThemePathPatterns();
}