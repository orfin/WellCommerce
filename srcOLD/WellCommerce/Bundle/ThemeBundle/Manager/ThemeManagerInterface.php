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

/**
 * Interface ThemeManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ThemeManagerInterface
{
    /**
     * Returns path patterns to theme folder
     *
     * @return string
     */
    public function getThemePathPattern();

    /**
     * Returns current theme folder
     *
     * @return string
     */
    public function getCurrentThemeFolder();

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
